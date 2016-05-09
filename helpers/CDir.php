<?php
namespace fec\helpers;
use Yii; 
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
	
}