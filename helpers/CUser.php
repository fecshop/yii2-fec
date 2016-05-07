<?php
namespace fec\helpers;
use Yii; 
//use yii\base\Model;
//use backend\models\helper\Base.php
# myapp\fec\helper\CConfig::getTheme();
class CUser
{
	# 是否登录
	public static function isLogin(){
		if($identity = Yii::$app->user->identity){
			return true;
		}
		return false;
	}
	
	# 得到当前的用户名
	public static function getCurrentUsername(){
		if($identity = Yii::$app->user->identity){
			if(isset($identity['username']) && !empty($identity['username'])){
				return $identity['username'];
			}
		}
		return '';
	}
	
	# 判断是否是超级用户
	public static function isSuperUser($user = ''){
		$superUser = self::getSuperUserConfig();
		if(!$user){
			$user = self::getCurrentUsername;
		}
		if($user && in_array($user,$superUser)){
			return true;
		}
		return false;
	}
	
	# 得到用户的配置。
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