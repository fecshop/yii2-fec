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
class CModel 
{


	# 1.将models 的错误信息转换成字符串
	public static function getErrorStr($errors){
		$str = '';
		if(is_array($errors)){
			foreach($errors as $field=>$error_k){
				$str .= $field.':'.implode(",",$error_k)." <br/>";
			}
		}
		return $str;
	}
	
}