<?php
namespace fec\helpers;
use Yii; 
class CMessage
{
	public static function error($info){
		CSession::getSessionM()->setFlash('error',$info);
	}
	
	public static function success($info){
		CSession::getSessionM()->setFlash('success', $info);
	}
	
}