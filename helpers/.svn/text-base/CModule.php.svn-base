<?php
/*
存放一些基本的非数据库数据。
一般都是数组设置。

*/
namespace fec\helpers;
use Yii; 
# \fec\helpers\CModule::param();
class CModule //extends CModule
{
	# 得到模块内部的配置
	public static function param($param,$moduleName=''){
		if($moduleName){
			//echo $moduleName;exit;
			return Yii::$app->getModule($moduleName)->params[$param];
		}else{
			return Yii::$app->controller->module->params[$param];
		
		}
	}
	# \fec\helpers\CModule::getToken();
	# 得到模块的 验证token
	public static function getToken(){
		
		$module_token = self::param('module_token');
		
		if($module_token){
			return $module_token;
		}else{
			return  CConfig::getDefaultModuleToken();
		}
	}
}