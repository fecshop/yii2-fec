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
class CFunc
{
	# 1.object 转换成  数组。
	public static function object_to_array($obj)
	{
		//$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
		if(is_object($obj) || is_array($obj)){
			if(is_object($obj)){
				$_arr = get_object_vars($obj);
			}else{
				$_arr = $obj;
			}
			foreach ($_arr as $key => $val)
			{
				$val = (is_array($val) || is_object($val)) ? self::object_to_array($val) : $val;
				$arr[$key] = $val;
			}
			return $arr;
		}else{
			return $obj;
		}
		
	}
	
	# 2.是否是时间格式
	public static function is_time($time)
	{
		$time = trim($time);
		$pattern1 = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s';
		$r1 =  preg_match($pattern1, $time);
		
		$pattern2 = '/^\d{4}-\d{2}-\d{2}$/s';
		$r2 =  preg_match($pattern2, $time);
		return ($r1 || $r2 );
	}
	
	# 3.对二维数组进行排序
	/*  譬如数组
		$arr = [
			['name' = 'x1','age'=33],
			['name' = 'y1','age'=11],
			['name' = 'a1','age'=66],
			['name' = 't1','age'=44],
		];
		$result = CFunc::array_sort($arr,'name','asc');
	*/
	# 二维数组进行排序
	# $array为要排序的数组
	# $keys为要用来排序的键名,二维数组的key
	# $type默认为升序排序 
	public static function array_sort($array,$keys,$dir='asc',$isFloat=true){  
		 
		$keysvalue = $new_array = array();  
		foreach ($array as $k=>$v){  
			if($isFloat){
				$keysvalue[$k] = (float)$v[$keys];
			}else{
				$keysvalue[$k] = $v[$keys];
			}  
		}  
		if($dir == 'asc'){  
			asort($keysvalue);  
		}else{  
			arsort($keysvalue);  
		}  
		reset($keysvalue);  
		foreach ($keysvalue as $k=>$v){  
			$new_array[$k] = $array[$k];  
		}  
		return $new_array;  
	}
	
	# 4.得到真实的IP
	public static function  get_real_ip(){
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) { 
				array_unshift($ips, $ip); $ip = FALSE; 
			}
			for ($i = 0; $i < count($ips); $i++) {
				if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		}
		
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
	
	# 得到4位小数点
	public function getFormatFloat($data,$decimal=4){
		return round($data,$decimal);
		
	}
	
}