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
class CSession
{
	
	public static function getSessionM(){
		return Yii::$app->session;
	}
	
	# 1. 设置session
	public static function set($key,$value){
		return self::getSessionM()->set($key,$value);
	}
	# 2.得到session
	public static function get($key){
		return self::getSessionM()->get($key);
	}
	# 3.删除session
	public static function remove($key){
		return self::getSessionM()->remove($key);
	}
}