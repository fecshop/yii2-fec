<?php
namespace fec\helpers;
use Yii; 
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

}