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
class CDate
{
	
	
	# 1.得到时间
	public static function getCurrentDateTime(){
		return date('Y-m-d H:i:s');
	}
	# 2.得到时间
	public static function getCurrentDate(){
		return date('Y-m-d');
	}
	
	# 3.判断时间大小
	# 1大于2则返回1，相等返回0，小于返回-1
	public static function ifIsBigDate($date1,$date2){

		if(strtotime($date1) > strtotime($date2)){
				return 1;
		}else if(strtotime($date1) == strtotime($date2)){
				return 0;
		}else{
				return -1;
		}
    }
	
	
	public static function getWeekOneDate($date){
		$week = date('w',strtotime($date));
		//echo $date;
		//echo $week;
		
		$c = $week - 1;
		return date("Y-m-d",strtotime($date." -$c days " ));
		
	}
	
	# 4.通过date，得到年-周。
	public static function getYearAndWeek($date){
		//$date = strtotime($date);
		$month = date('m',strtotime($date));
		$week = date('W',strtotime($date));
		$year = date('Y',strtotime($date));
		$intMonth = (int)$month;
		$intWeek  = (int)$week;
		if(($intMonth == 1) && $intWeek > 10){
			$week = "00";
		}
		return $year."-".$week;
	}
	
	# 得到间隔天数
	public static function diffBetweenTwoDays($day1, $day2)
	{
		$second1 = strtotime($day1);
		$second2 = strtotime($day2);
    
		return abs($second1 - $second2) / 86400;
	}

}