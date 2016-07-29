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
class CEmail
{
	public static function getMailer(){
		return  Yii::$app->mailer;
	}
	
	
	public static function getMailOb($from,$to,$title,$content,$is_html=1){
		if(!$from || !$to || !$title || !$content){
			return false;
		} 
		# 验证邮箱格式是否正确
		if(!self::email_validation($from)){
			return false;
		}
		# 验证邮箱格式是否正确
		if(!self::email_validation($to)){
			return false;
		}
		$m 	= 	self::getMailer()->compose()
				->setFrom($from)
				->setTo($to)
				->setSubject($title);
		if($is_html){
			$m->setHtmlBody($content);
		}else{
			$m->setTextBody($content);
		}
		return $m;
	
	}
	
	# 1.发送一封邮件
	# $from $to $title $content 不能为空。
	public static function sendMail($from,$to,$title,$content,$is_html=1){
		$m = self::getMailOb($from,$to,$title,$content,$is_html);
		if($m){
			$m->send();
			return true;
		}
		
		return false;
	}
	
	# 2.批量发送邮件
	/*
	参数：数组格式如下：
	$arr = [
		[
			'from' 	=>'zqy234@126.com',
			'to' 	=>'3727@gmail.com',
			'title' =>'my111',
			'content' =>'<div>111</div>',
			'is_html' => 1,
		],
		[
			'from' 	=>'zqy234@126.com',
			'to' 	=>'terry@gmail.com',
			'title' =>'to tototto',
			'content' =>'hello ddd',
			'is_html' => 0,
		],
	];
	 forece 代表多送多个邮件，其中一个邮件的格式或者数据为空的情况下，其他符合
	 标准的邮件是否发送
	 force=1,代表其他符合格式的邮件发送
	 force=0,如果某个邮件内容有问题，全部不发送。
	*/
	public static function sendMultipleEmail($arr,$forece=1){
		
		$messages = [];
		foreach ($arr as $one) {
			$from 		= isset($one['from']) ? $one['from'] : '';
			$to 		= isset($one['to']) ? $one['to'] : '';
			$title 		= isset($one['title']) ? $one['title'] : '';
			$content 	= isset($one['content']) ? $one['content'] : '';
			$is_html 	= isset($one['is_html']) ? $one['is_html'] : 0;
			
			$m = self::getMailOb($from,$to,$title,$content,$is_html);
			if(!$m){
				if(!$forece){ #如果数据格式有问题，force为0，则全部不发送
					return false;
				}
			}else{
				$messages[] = $m;
			}
		}
		if(!empty($messages)){
			$count = count($messages);
			self::getMailer()->sendMultiple($messages);
			# 返回发送的邮件的个数。
			return $count;
		}
		return false;
	}
	
	
	
	# 3.验证邮箱格式是否正确
	public static  function email_validation($mail)
	{
		if($mail != '')
		{
			if(preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $mail))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
}