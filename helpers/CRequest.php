<?php
/*
存放一些基本的非数据库数据。
一般都是数组设置。

*/
namespace fec\helpers;
use Yii; 

class CRequest 
{
	//const session;
	public static function getRequest(){
		return Yii::$app->request;
	}
	public static function post($key = ""){
		
		if($key){
			$v = self::getRequest()->post($key);
		}else{
			$v = self::getRequest()->post();
		}
		if($key == "_id"){
			$v = (int)$v;
		}
		return $v;
	}
	
	public static function set($key,$val){
		
		self::getRequest()->set($key,$val);
		
	}
	
	public static function get($key = ""){
		if($key){
			$v = self::getRequest()->get($key);
		}else{
			$v = self::getRequest()->get();
		}
		if($key == "_id"){
			$v = (int)$v;
		}
		return $v;
	}
	public static function param($key = ''){
		if($key){
			$get = self::get();
			$post = self::post();
			if($get[$key]){
				return $get[$key] ;
			}else if($post[$key]){
				return $post[$key] ;
			}else{
				return "";
			}
		}else{
			$get = self::get();
			$post = self::post();
			return array_merge($get,$post);
		}
	}
	public static function getCsrfName(){
		return self::getRequest()->csrfParam;
	}
	
	public static function getCsrfValue(){
		return self::getRequest()->getCsrfToken(); 
	}
	//得到csrf的input 的 html
	public static function getCsrfInputHtml(){
		echo '<input class="thiscsrf" type="hidden" value="'.self::getRequest()->getCsrfToken().'" name="'.self::getRequest()->csrfParam.'" />';
	}
        
        //得到csrf的input 的 html
	public static function returnCsrfInputHtml(){
		return '<input class="thiscsrf" type="hidden" value="'.self::getRequest()->getCsrfToken().'" name="'.self::getRequest()->csrfParam.'" />';
	}
	
	public static function getCsrfString(){
		return self::getRequest()->csrfParam."=".self::getRequest()->getCsrfToken();
	}
	
}






