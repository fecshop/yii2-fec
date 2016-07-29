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
class CTranslate
{
	
	const CURRENT_LANGUAGE = 'current_language';
	public static $current_language;
	
	
	# 翻译
	# 使用前需要配置：
	/*
		
                'i18n' => [
                        'translations' => [
                                '*' => [
                                        'class' => 'yii\i18n\PhpMessageSource',
                                        'basePath' =>'@frontend/language',  # 翻译语言的路径
                                        'sourceLanguage' => 'en_US',        # 默认语言
                                        'fileMap' => [
                                                'companie' => 'companie.php', # 翻译文件
                                        ],
                                ],
                        ],
                ],

	*/
	#  1.在使用前，需要设置当前的语言 CTranslate::setCurrentLanguage($language)；
	#  2.当然，也可以不设置语言，在本函数中传递语言参数到这个函数中
	#      语言格式为：en_US es_ES  de_DE  fr_FR 等
	#      如果不设置语言，默认为英语语言
	#  
	# 使用例子：Translate::__('my %s is very %s',array('son','big'));   
	public static function __($text,$arr = array(),$language='',$file=''){
		if(!$file){
			$file = 'companie';
		}
		if(!$language){
			$language = self::getCurrentLanguage();
		}
		Yii::$app->language = $language;
		$gText = Yii::t($file, $text);
		if(!empty($arr)){
			foreach($arr as $a){
				$gText = preg_replace('/%s/',$a,$gText,1);
			}
		}
		return $gText;
		
	}
	
	# 2.得到当前的language
	public static function getCurrentLanguage(){
		if(!self::$current_language){
			$language = CSession::get(self::CURRENT_LANGUAGE);
			if(!$language){
				$language = 'en_US';
			}
			self::$current_language = $language;
		}
		return self::$current_language;
	}
	
	# 3.设置当前的language
	public static function setCurrentLanguage($language){
		CSession::set(self::CURRENT_LANGUAGE,$language);	
	}
}




