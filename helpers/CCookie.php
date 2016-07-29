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
class CCookie
{
	public static function getCookieM(){
		return Yii::$app->request->cookies;
	}
	
	# 1.是否存在某个cookie
	public static function hasCookie($key){
		return self::getCookieM()->has($key);
	}
	
	# 2.得到某个cookie的值
	public static function getCookie($key,$default=''){
		return self::getCookieM()->getValue($key,$default);
	}
	
	# 3.设置cookie
	public static function setCookie($key,$val){
		self::getCookieM()->add(new \yii\web\Cookie([
			'name'  => $key,
			'value' => $val,
		]));
	}
	
	# 4.删除cookie
	public static function removeCookie($key){
		return self::getCookieM()->remove($key);
	}
	
}