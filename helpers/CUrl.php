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
	
	public static function getBaseUrl(){
		return self::getHomeUrl();
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
	
	public static function getUrl($url_path,$params=array()){
		$url_path = trim($url_path,DIRECTORY_SEPARATOR);
		$url =  self::getBaseUrl(). DIRECTORY_SEPARATOR .$url_path;
		$str = "";
		if(!empty($params) && is_array($params)){
			$str .= "?";
			foreach($params as $k=>$v){
				$str .= $k."=".$v."&";
			}
			$str = substr($str,0,strlen($str)-1);
		}
		return $url.$str;
	} 
	
	# 得到当前的完整url
	public static function getCurrentUrl(){
		$s =  self::getHomeUrl();
		return $s.$_SERVER["REQUEST_URI"];
	
	}
	# 得到当前的完整url  no param
	public static function getCurrentUrlNoParam(){
		$url = self::getCurrentUrl();
		if(strstr($url,"#")){
			$url = substr($url,0,strpos($url,"#"));
		}
		
		if(strstr($url,"?")){
			$url = substr($url,0,strpos($url,"?"));
		}
		return $url;
		
	}
	
	# 得到url key   ，譬如  http://www.x.com/ss/dd/aa?aaaa=ddddd   返回 /ss/dd/aa
	public static function getUrlKey(){
		
		return Yii::$app->request->getPathInfo();
	}
	# 得到url    ，譬如  http://www.x.com/ss/dd/aa?aaaa=ddddd   返回 /ss/dd/aa?aaaa=ddddd   
	public static function getUrlWithParam(){
		return Yii::$app->getRequest()->url;
	}
	
}