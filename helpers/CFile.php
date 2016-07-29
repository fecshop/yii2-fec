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
class CFile 
{
	
	
	# 1.保存前台上传的文件。
	public static function saveUploadFile($fileFullDir,$fileType = ''){
		if($fileType){
			$name = $_FILES["file"]["name"];
			if(strstr($name,$fileType)){
				$result = @move_uploaded_file($_FILES["file"]["tmp_name"],$fileFullDir);
			}	
		}else{
			
			$result = @move_uploaded_file($_FILES["file"]["tmp_name"],$fileFullDir);
		}
		return $result;
	}
	
	# 2.得到csv文件的内容，返回数组
	public static function getCsvFileContent($fileDir){
		$fp = @fopen($fileDir, "r"); 
		$content = [];
		if($fp){
			while(! @feof($fp)) 
			{ 
				$c = @fgets($fp);
				//$c = str_replace("\"","",$c);
				//$c = str_replace("'","",$c);
				$c_arr = explode(",",$c);
				$arr = [];
				foreach($c_arr as $v){
					$arr[] = trim($v);
				}
				$content[] = $arr; 
			
			} 
			fclose($fp); 
		}
		return $content;
	
	}
	
}