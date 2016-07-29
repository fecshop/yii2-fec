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
class CApi{
	
	# 1.通过函数访问api，获取数据
	#  JSON格式
	/*
		参数说明：  $url  为API访问的url
					$type 为请求类型，默认为get
					$data 为传递的数组数据
					$timeout 设置超时时间
		返回值：	返回API返回的数据
	*/
	public static function getCurlData($url,$type="get",$data=array(),$timeout = 10){
            //对空格进行转义
            $url = str_replace(' ','+',$url);
			if($type == "get"){
				if(!empty($data) && is_array($data)){
					
					$arr = [];
					foreach($data as $k=>$v){
						$arr[] = $k."=".$v;
					}
					$str  = implode("&",$arr);
					if(strstr($url,"?")){
						$url .= "&".$str;
					}else{
						$url .= "?".$str;
					}
				}
				
			}
			$data = json_encode($data);
			$url = urldecode($url);
			//echo $url ;exit;
            $ch = curl_init();
            //设置选项，包括URL
            curl_setopt($ch, CURLOPT_URL, "$url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);  //定义超时3秒钟  
            if($type == "post"){
				// POST数据
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, 
					CURLOPT_HTTPHEADER, 
					[
					'Accept: application/json',
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data)
					]
					);

				// 把post的变量加上
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
			//执行并获取url地址的内容
            $output = curl_exec($ch);
            //echo $output ;
            //释放curl句柄
            curl_close($ch);
			//var_dump($output);exit;
            return $output;
        
    }
	
}