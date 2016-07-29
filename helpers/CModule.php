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
class CModule //extends CModule
{
	# 1.得到模块内部的配置，模块的配置在模块的etc/config.php内
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