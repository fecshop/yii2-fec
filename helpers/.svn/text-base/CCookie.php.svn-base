<?php
namespace fec\helpers;
use Yii; 
class CCookie
{
	public static function getCookieM(){
		return Yii::$app->request->cookies;
	}
	
	# 是否存在某个cookie
	public static function hasCookie($key){
		return self::getCookieM()->has($key);
	}
	
	# 得到某个cookie的值
	public static function getCookie($key,$default=''){
		return self::getCookieM()->getValue($key,$default);
	}
	
	# 设置cookie
	public static function setCookie($key,$val){
		self::getCookieM()->add(new \yii\web\Cookie([
			'name'  => $key,
			'value' => $val,
		]));
	}
	
	#删除cookie
	public static function removeCookie($key){
		return self::getCookieM()->remove($key);
	}
	
}