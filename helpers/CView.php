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
use yii\base\View;
use yii\base\InvalidConfigException;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CView
{	
	# 功能块：
	# 本功能的作用是通过一个类文件，和一个view 文件，生成一个html块，而且在这个html中还可以嵌套其他的块
	# 这样设计的好处：譬如在前端，我们在很多url中都会有一些公用的侧栏块，我们很希望我们的块可以通过配置的方式很容易的加入到侧栏
	# 譬如电商网站侧栏的：客户的浏览记录，我们在多个页面都想加入这个功能，我们就可以很方便的做加入。
	
	# 默认的方法，功能块的提供数据的默认方法。可以在配置中配置method方法自定义。
	const DATA_METHOD = 'getLastData';
	
	/*  你可以在view 文件中通过下面的方式使用
		<?php

			use fec\helpers\CView;
			$config = [
				# 必填
				'class' => 'fec\block\TestMenu',
				'view'  => '@fec/views/testmenu/index.php',
				# 下面为选填
				'method'=> 'getLastData',
				'terry1'=> 'My1',
				'terry2'=> 'My2',
			];
			echo CView::getChildHtml($config)
			?>
	*/
    public static function getChildHtml($config)
    {
		if( !isset($config['view']) || empty($config['view'])
		){
			throw new InvalidConfigException('view and class must exist in array config!');
		}
		if( !isset($config['class']) || empty($config['class']))
			return Yii::$app->view->render($config['view'], []);
		$method = self::DATA_METHOD;
		if(isset($config['method']) && !empty($config['method'])){
			$method = $config['method'];
			unset($config['method']);
		}
		$view = $config['view'];
		unset($config['view']);
		$ob = Yii::createObject($config);
		$params = $ob->$method();
		return Yii::$app->view->render($view, $params);
		
    }
	# 通过配置
	/*
	1.add config param to modules params or application params.
	params.php
	[
		'params' => [
			'block' =>[
				'menu' =>[
					# 必填
					'class' => 'fec\block\TestMenu',
					'view'  => '@fec/views/testmenu/index.php',
					# 下面为选填
					'method'=> 'getLastData',
					'terry1'=> 'My1',
					'terry2'=> 'My2',
				],
			]
		]
	]
	2.
	use fec\helpers\CView;
	CView::getConfigChildHtml('menu');
	*/
	public static function getConfigChildHtml($configKey){
		$config = [];
		# get config from module param 
		if($module = Yii::$app->controller->module){
			$module_config = CModule::param("block");
			if(isset($module_config[$configKey])){
				$config = $module_config[$configKey];
			}
		}
		# if module config param is empty or not exist,
		# get config from application
		if(empty($config)){
			$app_config = CConfig::param("block");
			if(isset($app_config[$configKey])){
				$config = $app_config[$configKey];
			}
		}
		
		if(!isset($config['view']) || empty($config['view'])
		){
			throw new InvalidConfigException('view and class must exist in array config!');
		}else{
			return self::getChildHtml($config);
		}
		
	}
} 