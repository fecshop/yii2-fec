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
class CUser
{
	# 1.检测用户是否登录
	public static function isLogin(){
		if($identity = Yii::$app->user->identity){
			return true;
		}
		return false;
	}
	
	# 2.得到当前的用户名
	public static function getCurrentUsername(){
		if($identity = Yii::$app->user->identity){
			if(isset($identity['username']) && !empty($identity['username'])){
				return $identity['username'];
			}
		}
		return '';
	}
	
	# 3.得到当前用户的id
	public static function getCurrentUserId(){
		if($identity = Yii::$app->user->identity){
			if(isset($identity['id']) && !empty($identity['id'])){
				return $identity['id'];
			}
		}
		return '';
	}
	
	# 3.判断是否是超级用户，需要配置项：super_admin_user
	public static function isSuperUser($user = ''){
		$superUser = self::getSuperUserConfig();
		if(!$user){
			$user = self::getCurrentUsername();
		}
		if($user && in_array($user,$superUser)){
			return true;
		}
		return false;
	}
	
	# 4.得到用户的配置。
	public static function getSuperUserConfig(){
		$superUser = ['admin'];
		$configSuperUser = CConfig::param('super_admin_user');
		if(is_array($configSuperUser) && !empty($configSuperUser)){
			$superUser = array_merge($superUser,$configSuperUser);
			$superUser = array_unique($superUser);
		}
		return $superUser;
	}
	
	
	
	
}