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
use yii\base\InvalidValueException; 
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CDir
{
	# 1.得到web路径在linux下面的地址
	public static function getBaseDir(){
		return Yii::getAlias('@webroot');
	}
	# 2.得到  @webroot/media
	public static function getMediaDir(){
		return self::getBaseDir()."/media";
	}
	
	/**
	 * @property $baseDir | String, create folder in this  dir.
	 * @property $createdDir| String, create folder
	 * Example: $baseDir = '/www/web/fecshop/web',$createdDir='a/b/c';
	 * this function return /www/web/fecshop/web/a/b/c
	 */
	public static function createFloder($baseDir,$createdDir){
		if(!is_dir($baseDir)){
			throw new InvalidValueException('base dir is not a correct dir');
		}
		if(!$createdDir){
			throw new InvalidValueException('created dir can not empty');
		}
		if(!is_array($createdDir)){
			$createdDir = trim($createdDir,'/');
			$dir_arr = explode('/',$createdDir);
		}else{
			$dir_arr = $createdDir;
		}
		$dir = $baseDir;
		foreach($dir_arr as $folder){
			$dir = $dir.'/'.$folder;
			if(!is_dir($dir)){
				@mkdir($dir,0777);
			}
		}
        if(is_dir($dir)){
            return $dir;
        }else{
            return false;
        }
		
	}
	
	
	
}