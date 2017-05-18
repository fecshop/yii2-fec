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
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */ 
class CUrl
{
	public static $_baseHttpUrl;
	public static $_baseHttpsUrl;
	# 1.获取首页地址。
	public static function getHomeUrl(){
		return Yii::$app->getHomeUrl();
		//return Yii::$app->getBaseUrl(true);
	}
	# 2. 获取首页地址。同上
	public static function getBaseUrl(){
		if(!self::$_baseHttpsUrl){
			if(\Yii::$app->urlManager->enablePrettyUrl && (!\Yii::$app->urlManager->showScriptName)){
				self::$_baseHttpsUrl = self::getHomeUrl().'/index.php';
			}
			self::$_baseHttpsUrl = self::getHomeUrl();
		}
		return self::$_baseHttpsUrl;
		
	}
	
	# 3.立即跳转  和 yii2的跳转还是不同
	public static function redirect($url,$isHttps=false){
		if($url){
			if(substr($url,0,4) != "http"){
				$url = self::getUrl($url,[],$isHttps);	
			}
			header("Location: $url");
			exit;
		}
	}
	
	
	
	#5. 通过url path 和参数  得到当前网站下的完整url路径。
	public static function getUrl($url_path,$params=array(),$isHttps=false){
		$url_path = trim($url_path,'/');
		$url =  self::getBaseUrl(). '/' .$url_path;
		if(!empty($params) && is_array($params)){
			$arr = [];
			foreach($params as $k=>$v){
				$arr[] = $k."=".$v;
			}
			return $url.'?'.implode('&',$arr);
		}
		return $url;
	} 
	
	# 6.得到当前的完整url
	public static function getCurrentUrl(){
		//$s =  self::getHomeUrl();
		//return $s.$_SERVER["REQUEST_URI"];
		return \yii\helpers\Url::current();
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