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
class CConfig
{
	public static function param($param){
		if(isset(Yii::$app->params[$param])){
			return Yii::$app->params[$param];
		}
		return ;
	}
	# 1.得到当前的配置模板
	public static function getCurrentTheme(){
		return self::param("theme") ? self::param("theme") : 'default';
	}
	
	# 2.得到默认的module  的 token 配置
	# CConfig::getDefaultModuleToken();
	public static function getDefaultModuleToken(){
		return self::param("default_module_token") ? self::param("default_module_token") : '';
	}
}