<?php
namespace fec\helpers;
use Yii; 
class CMessage
{
	# 1.将错误信息写入到flash session。
	public static function error($info){
		CSession::getSessionM()->setFlash('error',$info);
	}
	
	# 2.将成功信息写入到flash session。
	public static function success($info){
		CSession::getSessionM()->setFlash('success', $info);
	}
	
}