<?php
namespace fec\helpers;
use Yii; 
//use yii\base\Model;
//use backend\models\helper\Base.php
# myapp\fec\helper\CConfig::getTheme();
class CFunc
{
	
	
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
	public static function is_time($time)
	{
		$time = trim($time);
		$pattern1 = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s';
		$r1 =  preg_match($pattern1, $time);
		
		$pattern2 = '/^\d{4}-\d{2}-\d{2}$/s';
		$r2 =  preg_match($pattern2, $time);
		return ($r1 || $r2 );
	}
	
	
	public static function array_sort($array,$keys,$type='asc'){  
		//$array为要排序的数组,$keys为要用来排序的键名,$type默认为升序排序  
		$keysvalue = $new_array = array();  
		foreach ($array as $k=>$v){  
		$keysvalue[$k] = $v[$keys];  
		}  
		if($type == 'asc'){  
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
	
}