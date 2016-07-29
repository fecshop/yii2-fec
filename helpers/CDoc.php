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
class CDoc
{
	
	# 3.通过数组生成html文档样式
	/*
		$array = [
			'title' 		=> '1111',
			'description' 	=> 'xxxxxxxxxxxx',
			'content' 		=> [
				['aaa','bbbb'],
				['aaaaa','bbbbbbbbb'],
			],
		];
	
	*/
	public static function tableformat($array){  
		
		
		
		$t_str = '';
		$content = $array['content'];
		$i = 0;
		
								
		if(is_array($content) && !empty($content)){
			foreach($content as $d){
				$i++;
				if($i == 1){
					$t_str .='<thead><tr>';
					if(is_array($d) && !empty($d)){
						foreach($d as $v){
							$t_str .='<th>'.$v.'</th>';
						}
					}
					$t_str .='</tr></thead>';
				}else{
					if($i == 2)
						$t_str .='<tbody>';
					
					$t_str .='<tr>';
					if(is_array($d) && !empty($d)){
						foreach($d as $v){
							$t_str .='<td>'.$v.'</td>';
						}
					}
					$t_str .='</tr>';
					
				}
				
			}
			$t_str .='</tbody>';
		}
		$str = '
			<style>
			table.list th:first-child{
				width:22%;
				
			}
			</style>
			<table class="list" style="width:100%">
				<thead>
					<tr>
						<th>'.$array['title'].'</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>
							'.$array['description'].'
							<br/>
							
							<table class="list" style="width:100%">
								'.$t_str.'
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		<br/>';
		
		return $str;
			
	}
	
}