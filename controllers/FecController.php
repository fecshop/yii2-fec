<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fec\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class FecController extends Controller
{
	# 
   public function getBlock($blockname=''){
	    $_currentNameSpace = \fec\helpers\CModule::param("_currentNameSpace");
		if(empty($_currentNameSpace)){
			$message = "Modules Param '_currentNameSpace'  is not set , you can set like fecadmin\\Module";
			throw new \yii\web\HttpException(406,$message);
		}
		$modulesDir = "\\".$_currentNameSpace."\\block\\";
		$url_key = \fec\helpers\CUrl::getUrlKey();
		$url_key = trim($url_key,"/");
		$url_key = substr($url_key,strpos($url_key,"/")+1 );
		$url_key_arr = explode("/",$url_key);
		if(!isset($url_key_arr[1])) $url_key_arr[1] = 'index';
		if($blockname){
			$url_key_arr[count($url_key_arr)-1] = ucfirst($blockname);
		}else{
			$url_key_arr[count($url_key_arr)-1] = ucfirst($url_key_arr[count($url_key_arr)-1]);
		}
		
		$block_space = implode("\\",$url_key_arr);
		$blockFile = $modulesDir.$block_space;
		//echo $blockFile;exit;
		return new $blockFile;
		
    }
}
