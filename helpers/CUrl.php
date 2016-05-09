<?php
namespace fec\helpers;
use Yii; 
class CUrl
{
	
	# 1.获取首页地址。
	public static function getHomeUrl(){
		return Yii::$app->getHomeUrl();
		//return Yii::$app->getBaseUrl(true);
	}
	# 2. 获取首页地址。同上
	public static function getBaseUrl(){
		return self::getHomeUrl();
	}
	
	# 3.立即跳转  和 yii2的跳转还是不同
	public static function redirect($url){
		if($url){
			if(substr($url,0,7) != "http://"){
				$url = self::getUrl($url);	
			}
			header("Location: $url");
			exit;
		}
	}
	
	# 4.通过模板name，得到对应文件路径。
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
	
	#5. 通过url path 和参数  得到当前网站下的完整url路径。
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
	
	# 6.得到当前的完整url
	public static function getCurrentUrl(){
		$s =  self::getHomeUrl();
		return $s.$_SERVER["REQUEST_URI"];
	
	}
	# 7.得到当前的完整url  no param
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
	
	# 8、得到url key   ，譬如  http://www.x.com/ss/dd/aa?aaaa=ddddd   返回 /ss/dd/aa
	public static function getUrlKey(){
		
		return Yii::$app->request->getPathInfo();
	}
	# 9.得到url    ，譬如  http://www.x.com/ss/dd/aa?aaaa=ddddd   返回 /ss/dd/aa?aaaa=ddddd   
	public static function getUrlKeyWithParam(){
		return Yii::$app->getRequest()->url;
	}
	
}