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
# 本功能使用前，需要配置log
#  参看地址：http://blog.csdn.net/terry_water/article/details/51250478
# 没有配置前，本功能不能使用。
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CLog
{
	# 1.数据库Log ，将错误信息输出到表：system_log
	# 	common\config\main.php
	public static function dbinfo($info,$categories = 'db_mysql'){
		$info = self::getInfo($info));
		if($info && $categories)
			\Yii::info($info,$categories);  
	}
	# 2.文件Log，详细的输出路径参看配置。
	# 目前的输出地址为：@app/runtime/logs/file_log.log
	public static function fileinfo($info,$categories = 'file_log'){
		$info = self::getInfo($info));
		if($info && $categories)
			\Yii::info($info,$categories); 
	}
	# 3.信息的转换，将object，array 转换成字符串，以供输出。 
	public static function getInfo($info){
		if(!$info)
			return false;
		if(is_object($info))
			$info = CFunc::object_to_array($info);
		if(is_array($info))
			$info = json_encode($info);
		return $info;
	}
	
}