<?php
namespace fec\helpers;
use Yii; 
//use yii\base\Model;
//use backend\models\helper\Base.php
# myapp\fec\helper\CConfig::getTheme();
class CDate
{
	
	
	# 获取首页地址。
	public static function getCurrentDateTime(){
		return date('Y-m-d H:i:s');
	}
	
	public static function getCurrentDate(){
		return date('Y-m-d');
	}
	
}