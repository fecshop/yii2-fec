<?php
namespace fec\helpers;
use Yii; 

class CImage
{
	# 保存上传的图片。
	public static function saveUpload($fileFullDir){
		if(isset($_FILES["imgfile"])){
			$name = $_FILES["imgfile"]["name"];
			
			if($name && ($type = self::isCorrectImageType($name))){
				$str = rand(10, 99).rand(10,99);
				$imgName = "task_advance_".date("Y-m-d-H-i-s").$str.$type;
				$imgDir = $fileFullDir."/".$imgName;
				$result = @move_uploaded_file($_FILES["imgfile"]["tmp_name"],$imgDir);
				if($result){
					return $imgName;
				}
			}	
			
		}
		return false;
	}
	# 验证图片文件后缀是否正确
	public static function isCorrectImageType($imageName){
		$imageType = self::getImageType();
		foreach($imageType as $type){
			if(strstr($imageName,$type)){
				return $type;
			}
		}
		return false;
	}
	
	public static function getImageType(){
		return [
			'.jpg','.gif','.png','.jpeg'
		];
	}
	
}