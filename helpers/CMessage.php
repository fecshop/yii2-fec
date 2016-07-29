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