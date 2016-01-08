<?php
namespace fec\helpers;
use Yii; 
//use yii\base\Model;
//use backend\models\helper\Base.php
# myapp\fec\helper\CConfig::getTheme();
class CUrl
{
	
	
	# 获取首页地址。
	public static function getHomeUrl(){
		return Yii::$app->getHomeUrl();
		//return Yii::$app->getBaseUrl(true);
	}
	
	# 默认是 domain.com/skin/theme/下面的绝对URL
	public static function getSkinUrl($dir = '',$relative_path=false){
		$currentTheme = CConfig::getCurrentTheme();
		$url = '';
		if(!$relative_path){
			$url = self::getHomeUrl(). DIRECTORY_SEPARATOR;
		}
		return  $url.'skin'.DIRECTORY_SEPARATOR
				.$currentTheme.DIRECTORY_SEPARATOR
				.$dir;
	}
	
	public static function getUrlKey(){
		return ;
	}
	
}