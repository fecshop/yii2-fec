<?php
namespace fec\helpers;
use Yii; 
# 本功能使用前，需要配置log
#  参看地址：http://blog.csdn.net/terry_water/article/details/51250478
# 没有配置前，本功能不能使用。
class CLog
{
	# common\config\main.php
	# 数据库Log ，输出表为：system_log
	public static function dbinfo($info,$categories = 'db_mysql'){
		$info = self::getInfo($info));
		if($info && $categories)
			\Yii::info($info,$categories);  
	}
	# 文件Log
	# 输出地址为：@app/runtime/logs/file_log.log
	public static function fileinfo($info,$categories = 'file_log'){
		$info = self::getInfo($info));
		if($info && $categories)
			\Yii::info($info,$categories); 
	}
	
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