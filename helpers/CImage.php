<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fec\helpers;
use Yii; 
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Imagine\Image\Color;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CImage
{
	/**
     * GD2 driver definition for Imagine implementation using the GD library.
     */
    const DRIVER_GD2 = 'gd2';
    /**
     * imagick driver definition.
     */
    const DRIVER_IMAGICK = 'imagick';
    /**
     * gmagick driver definition.
     */
    const DRIVER_GMAGICK = 'gmagick';
    /**
     * @var array|string the driver to use. This can be either a single driver name or an array of driver names.
     * If the latter, the first available driver will be used.
     */
    public static $driver = [self::DRIVER_GMAGICK, self::DRIVER_IMAGICK, self::DRIVER_GD2];
    /**
     * @var ImagineInterface instance.
     */
    private static $_imagine;
    /**
     * @var string background color to use when creating thumbnails in `ImageInterface::THUMBNAIL_INSET` mode with
     * both width and height specified. Default is white.
     *
     * @since 2.0.4
     */
    public static $thumbnailBackgroundColor = 'FFF';
    /**
     * @var string background alpha (transparency) to use when creating thumbnails in `ImageInterface::THUMBNAIL_INSET`
     * mode with both width and height specified. Default is solid.
     *
     * @since 2.0.4
     */
    public static $thumbnailBackgroundAlpha = 100;
    
	
	
	
	/**
	 * @property $imgPath|String 原来图片的绝对路径
	 * @property $newPath|String 压缩尺寸，并加入水印后的图片保存路径。
	 * @property $resize|Array or String 图片压缩后的宽度，[111,222];
	 * @property $waterMark|String 水印图片的绝对路径
	 * 生成新的带有水印的缩略图，水印图片默认放到中间位置。
	 * newPath 要保证改路径存在并可写。如果水印图片比resize的尺寸大，则水印图片将不会被添加到生成的图片上面
	 * $resizeWidth 和 $resizeHeight，允许其中一个设置为0，如果为0，
	 * @return  
	 */
	
	public static function saveResizeMiddleWaterImg($imgPath, $newPath, $resize, $waterMark='', $options = []){
		//exit;
		$image = static::getImagine()->open($imgPath);
		$sourceBox 	= $image->getSize();
		$imgWidth 	= $sourceBox->getWidth();
		$imgHeight 	= $sourceBox->getHeight();
		if(is_array($resize)){
			list($resizeWidth,$resizeHeight) = $resize;
		}else{
			$resizeWidth = $resize;
			$resizeHeight = $resizeWidth * $imgHeight / $imgWidth;
		}
		//echo 22;
		//echo $resizeWidth.' && '.$resizeHeight;
		//exit;
		if(!$resizeWidth && !$resizeHeight){
			return false;
		}
		// 得到图片不失真情况下的缩放尺寸
		$imgRate = $imgWidth/$imgHeight;
		$resizeRate = $resizeWidth/$resizeHeight;
		
		if($imgRate >= $resizeRate){
			$resizeImgWidth = $resizeWidth;
			$resizeImgHeight = $resizeImgWidth * $imgHeight / $imgWidth;
		}else{
			$resizeImgHeight = $resizeHeight;
			$resizeImgWidth = $resizeImgHeight * $imgWidth / $imgHeight;
		}
		
		//得到背景图片
		$imagine = static::getImagine();
		//$palette = new \Imagine\Image\Palette\RGB();
		$size  = new \Imagine\Image\Box($resizeWidth, $resizeHeight);
		//$color = $palette->color($backgroundColor);
		$gr_image = $imagine->create($size);
		//$gr_image->save($newPath);
		
		$image->resize(new Box($resizeImgWidth, $resizeImgHeight ));
		// 和空白图片合并
		$startX = ($resizeWidth - $resizeImgWidth)/2 ;
		$startY = ($resizeHeight - $resizeImgHeight)/2 ;
		$startX = ($startX > 0) ? $startX : 0;
		$startY = ($startY > 0) ? $startY : 0;
		$start = [$startX,$startY];
		$gr_image->paste($image, new Point($start[0], $start[1]));
		
		if($waterMark){
			$waterImage = static::getImagine()->open($waterMark);
			$waterSourceBox 		= $waterImage->getSize();
			$watermarkWidth = $waterSourceBox->getWidth();
			$watermarkHeight= $waterSourceBox->getHeight();
			if(($resizeWidth >= $watermarkWidth)
			&& ($resizeHeight >= $watermarkHeight)
			){
				$startX = ($resizeWidth - $watermarkWidth)/2 ;
				$startY = ($resizeHeight - $watermarkHeight)/2 ;
				$startX = ($startX > 0) ? $startX : 0;
				$startY = ($startY > 0) ? $startY : 0;
				$start = [$startX,$startY];
				$gr_image->paste($waterImage, new Point($start[0], $start[1]));
			}
		}
        ;
		$gr_image->save($newPath, $options);
	}
	
	
	
	
	# 1.保存缩略图
	# $oldImgFile ：原来的图片路径   web 目录下面加入@webroot
	# $newImgFile : 新保存的图片路径
	# $width, $height ：新图片的长宽。
	/*example:
		$oldImgFile = "@webroot/media/ebay_task/7777.jpg";
		$newImgFile = "@webroot/media/ebay_task/22.jpg";
		$width = 200;
		$height= 230;
		CImage::saveThumbnail($oldImgFile,$newImgFile ,$width, $height);
		文件将被保存到新文件路径，如果文件存在，则 被覆盖
	*/
	public static function saveThumbnail($oldImgFile,$newImgFile ,$resize, $mode = ManipulatorInterface::THUMBNAIL_INSET)
    {
		$width 	= $resize['width'];
		$height = $resize['height'];
		$imageModle = self::thumbnail($oldImgFile, $width, $height,$mode);
		$newImgFile = Yii::getAlias($newImgFile);
		$imageModle->save($newImgFile);
	}
	
	# 2、保存水印图片到新的路径。
	# 类似于 下面的 saveMiddleWaterMark ，不同的start X,Y  是自定义的
	# 可以通过参数的形式传递
	public static function  saveWaterMark($waterMarkFilename,$oldImgFile,$newImgFile, array $start = [0, 0]){
		
		$imageModle = self::watermark($oldImgFile, $waterMarkFilename, $start);
		$newImgFile = Yii::getAlias($newImgFile);
		$imageModle->save($newImgFile);
	}
	# 3.保存水印图片到新的路径（水印图片在中间位置）
	/*  #2. 使用的example
		$oldImgFile 		= "@webroot/media/ebay_task/7777.jpg";
		$waterMarkFilename 	= "@webroot/media/ebay_task/3333333.png";
		$newImgFile 		= "@webroot/media/ebay_task/11.jpg";
		CImage::saveMiddleWaterMark($waterMarkFilename,$oldImgFile,$newImgFile);
		# 作用，给一个图片加水印，水印放到地图的中间的位置。
	*/
	public static function  saveMiddleWaterMark($waterMarkFilename,$oldImgFile,$newImgFile){
		
		$imageModle = self::middlewatermark($oldImgFile, $waterMarkFilename, $start);
		$newImgFile = Yii::getAlias($newImgFile);
		$imageModle->save($newImgFile);
	}
	
	
	
	public static function middlewatermark($filename, $watermarkFilename)
    {
        
        $img = static::getImagine()->open(Yii::getAlias($filename));
        $watermark = static::getImagine()->open(Yii::getAlias($watermarkFilename));
        
		$sourceBox 	= $img->getSize();
		$imgWidth 	= $sourceBox->getWidth();
		$imgHeight 	= $sourceBox->getHeight();
		
		$sourceBox 		= $watermark->getSize();
		$watermarkWidth = $sourceBox->getWidth();
		$watermarkHeight= $sourceBox->getHeight();
		
		$startX = ($imgWidth - $watermarkWidth)/2 ;
		$startY = ($imgHeight - $watermarkHeight)/2 ;
		$startX = ($startX > 0) ? $startX : 0;
		$startY = ($startY > 0) ? $startY : 0;
		$start = [$startX,$startY];
		$img->paste($watermark, new Point($start[0], $start[1]));
        return $img;
    }
	
	
	#######################################################
	# 下面是yii2插件部分的代码。
	
	/**
     * Returns the `Imagine` object that supports various image manipulations.
     * @return ImagineInterface the `Imagine` object
     */
    public static function getImagine()
    {
        if (self::$_imagine === null) {
            self::$_imagine = static::createImagine();
        }
        return self::$_imagine;
    }
    /**
     * @param ImagineInterface $imagine the `Imagine` object.
     */
    public static function setImagine($imagine)
    {
        self::$_imagine = $imagine;
    }
    /**
     * Creates an `Imagine` object based on the specified [[driver]].
     * @return ImagineInterface the new `Imagine` object
     * @throws InvalidConfigException if [[driver]] is unknown or the system doesn't support any [[driver]].
     */
    protected static function createImagine()
    {
        foreach ((array) static::$driver as $driver) {
            switch ($driver) {
                case self::DRIVER_GMAGICK:
                    if (class_exists('Gmagick', false)) {
                        return new \Imagine\Gmagick\Imagine();
                    }
                    break;
                case self::DRIVER_IMAGICK:
                    if (class_exists('Imagick', false)) {
                        return new \Imagine\Imagick\Imagine();
                    }
                    break;
                case self::DRIVER_GD2:
                    if (function_exists('gd_info')) {
                        return new \Imagine\Gd\Imagine();
                    }
                    break;
                default:
                    throw new InvalidConfigException("Unknown driver: $driver");
            }
        }
        throw new InvalidConfigException("Your system does not support any of these drivers: " . implode(',', (array) static::$driver));
    }
    /**
     * Crops an image.
     *
     * For example,
     *
     * ~~~
     * $obj->crop('path\to\image.jpg', 200, 200, [5, 5]);
     *
     * $point = new \Imagine\Image\Point(5, 5);
     * $obj->crop('path\to\image.jpg', 200, 200, $point);
     * ~~~
     *
     * @param string $filename the image file path or path alias.
     * @param integer $width the crop width
     * @param integer $height the crop height
     * @param array $start the starting point. This must be an array with two elements representing `x` and `y` coordinates.
     * @return ImageInterface
     * @throws InvalidParamException if the `$start` parameter is invalid
     */
    public static function crop($filename, $width, $height, array $start = [0, 0])
    {
        if (!isset($start[0], $start[1])) {
            throw new InvalidParamException('$start must be an array of two elements.');
        }
        return static::getImagine()
            ->open(Yii::getAlias($filename))
            ->copy()
            ->crop(new Point($start[0], $start[1]), new Box($width, $height));
    }
	
	
	
    /**
		ManipulatorInterface::THUMBNAIL_INSET
		ManipulatorInterface::THUMBNAIL_OUTBOUND
     */
    public static function thumbnail($filename, $width, $height, $mode = ManipulatorInterface::THUMBNAIL_INSET)
    {
        $img = static::getImagine()->open(Yii::getAlias($filename));
        $sourceBox = $img->getSize();
        $thumbnailBox = static::getThumbnailBox($sourceBox, $width, $height);
        if (($sourceBox->getWidth() <= $thumbnailBox->getWidth() && $sourceBox->getHeight() <= $thumbnailBox->getHeight()) || (!$thumbnailBox->getWidth() && !$thumbnailBox->getHeight())) {
            return $img->copy();
        }
        $img = $img->thumbnail($thumbnailBox, $mode);
        // create empty image to preserve aspect ratio of thumbnail
        $thumb = static::getImagine()->create($thumbnailBox, new Color(static::$thumbnailBackgroundColor, static::$thumbnailBackgroundAlpha));
        // calculate points
        $startX = 0;
        $startY = 0;
        if ($sourceBox->getWidth() < $width) {
            $startX = ceil($width - $sourceBox->getWidth()) / 2;
        }
        if ($sourceBox->getHeight() < $height) {
            $startY = ceil($height - $sourceBox->getHeight()) / 2;
        }
        $thumb->paste($img, new Point($startX, $startY));
        return $thumb;
    }
    /**
     * Adds a watermark to an existing image.
     * @param string $filename the image file path or path alias.
     * @param string $watermarkFilename the file path or path alias of the watermark image.
     * @param array $start the starting point. This must be an array with two elements representing `x` and `y` coordinates.
     * @return ImageInterface
     * @throws InvalidParamException if `$start` is invalid
     */
    public static function watermark($filename, $watermarkFilename, array $start = [0, 0])
    {
        if (!isset($start[0], $start[1])) {
            throw new InvalidParamException('$start must be an array of two elements.');
        }
        $img = static::getImagine()->open(Yii::getAlias($filename));
        $watermark = static::getImagine()->open(Yii::getAlias($watermarkFilename));
        $img->paste($watermark, new Point($start[0], $start[1]));
        return $img;
    }
    /**
     * Draws a text string on an existing image.
     * @param string $filename the image file path or path alias.
     * @param string $text the text to write to the image
     * @param string $fontFile the file path or path alias
     * @param array $start the starting position of the text. This must be an array with two elements representing `x` and `y` coordinates.
     * @param array $fontOptions the font options. The following options may be specified:
     *
     * - color: The font color. Defaults to "fff".
     * - size: The font size. Defaults to 12.
     * - angle: The angle to use to write the text. Defaults to 0.
     *
     * @return ImageInterface
     * @throws InvalidParamException if `$fontOptions` is invalid
     */
    public static function text($filename, $text, $fontFile, array $start = [0, 0], array $fontOptions = [])
    {
        if (!isset($start[0], $start[1])) {
            throw new InvalidParamException('$start must be an array of two elements.');
        }
        $fontSize = ArrayHelper::getValue($fontOptions, 'size', 12);
        $fontColor = ArrayHelper::getValue($fontOptions, 'color', 'fff');
        $fontAngle = ArrayHelper::getValue($fontOptions, 'angle', 0);
        $img = static::getImagine()->open(Yii::getAlias($filename));
        $font = static::getImagine()->font(Yii::getAlias($fontFile), $fontSize, new Color($fontColor));
        $img->draw()->text($text, $font, new Point($start[0], $start[1]), $fontAngle);
        return $img;
    }
    /**
     * Adds a frame around of the image. Please note that the image size will increase by `$margin` x 2.
     * @param string $filename the full path to the image file
     * @param integer $margin the frame size to add around the image
     * @param string $color the frame color
     * @param integer $alpha the alpha value of the frame.
     * @return ImageInterface
     */
    public static function frame($filename, $margin = 20, $color = '666', $alpha = 100)
    {
        $img = static::getImagine()->open(Yii::getAlias($filename));
        $size = $img->getSize();
        $pasteTo = new Point($margin, $margin);
        $padColor = new Color($color, $alpha);
        $box = new Box($size->getWidth() + ceil($margin * 2), $size->getHeight() + ceil($margin * 2));
        $image = static::getImagine()->create($box, $padColor);
        $image->paste($img, $pasteTo);
        return $image;
    }
    
    /**
     * Returns box for a thumbnail to be created. If one of the dimensions is set to `null`, another one is calculated
     * automatically based on width to height ratio of original image box.
     *
     * @param BoxInterface $sourceBox original image box
     * @param int $width thumbnail width
     * @param int $height thumbnail height
     * @return BoxInterface thumbnail box
     *
     * @since 2.0.4
     */
    protected static function getThumbnailBox(BoxInterface $sourceBox, $width, $height)
    {
        if ($width !== null && $height !== null) {
            return new Box($width, $height);
        }
        if ($width === null && $height === null) {
            throw new InvalidParamException('Width and height cannot be null at same time.');
        }
        $ratio = $sourceBox->getWidth() / $sourceBox->getHeight();
        if ($height === null) {
            $height = ceil($width / $ratio);
        } else {
            $width = ceil($height * $ratio);
        }
        return new Box($width, $height);
    }
	
}