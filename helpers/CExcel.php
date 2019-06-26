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
class CExcel 
{
	# 1.加载phpExcel组件文件
	public static function prepare(){
		require_once(__DIR__."/../lib/PHPExcel/PHPExcel.php");
		require_once(__DIR__."/../lib/PHPExcel/PHPExcel/IOFactory.php");
		require_once(__DIR__."/../lib/PHPExcel/PHPExcel/Reader/Excel2007.php");
		
	}
	
	# 2.得到excel文件的内容
	public static function getExcelContent($xlsDir){
		self::prepare();
		//echo $xlsDir;exit;
		$objPHPExcel = \PHPExcel_IOFactory::load($xlsDir);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		return $sheetData;
		
	}
	
	
	# 3.array中的数据，以excel的方式下载下来。
	# $data 是数据数组
	# $fileName 是文件名字
	/*
		参数说明
		$data = [
				[11,22,33,44],
				[131,22,33,44],
			];
		使用方式：\fec\helpers\CExcel::downloadExcelFileByArray($data);
		调用这个方法后，会下载excel文件。
	*/	
		
	
	public static function downloadExcelFileByArray($data,$fileName=''){
		self::prepare();
		if(!$fileName){
			$fileName = 'xls-download-'.date('Y-m-d-H-i-s').'.xls';
		}
		$objPHPExcel = new \PHPExcel();
		$objPHPExcel->getActiveSheet()->fromArray($data);
		$objPHPExcel->getActiveSheet()->freezePane('A2');
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}
	
	
}









