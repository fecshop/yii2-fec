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
class CRequest 
{
	public static function getRequest(){
		return Yii::$app->request;
	}
	# 1.得到post请求类型的数据
	public static function post($key = ""){
		
		if($key){
			$v = self::getRequest()->post($key);
		}else{
			$v = self::getRequest()->post();
		}
		return $v;
	}
	# 2.设置
	public static function set($key,$val){
		return self::getRequest()->set($key,$val);
	}
	# 3.得到get请求类型的数据
	public static function get($key = ""){
		if($key){
			$v = self::getRequest()->get($key);
		}else{
			$v = self::getRequest()->get();
		}
		return $v;
	}
	# 4.得到get 和 post的所有数据。 
	# 如果一个值在get和post中都存在，则post优先。
	public static function param($key = ''){
		if($key){
			$get = self::get();
			$post = self::post();
			if(isset($post[$key])){
				return $post[$key] ;
			}else if(isset($get[$key])){
				return $get[$key] ;
			}else{
				return "";
			}
		}else{
			$get = self::get();
			$post = self::post();
			return array_merge($get,$post);
		}
	}
	# 5.得到csrfName
	public static function getCsrfName(){
		return self::getRequest()->csrfParam;
	}
	# 6.得到csrf对应的值。
	public static function getCsrfValue(){
		return self::getRequest()->getCsrfToken(); 
	}
	# 7.得到csrf的input 的 html
	public static function getCsrfInputHtml(){
		return '<input class="thiscsrf" type="hidden" value="'.self::getCsrfValue().'" name="'.self::getCsrfName().'" />';
	}
    
	# 8.得到csrf对应的字符串
	public static function getCsrfString(){
		return self::getCsrfName()."=".self::getCsrfValue();
	}
	
}






