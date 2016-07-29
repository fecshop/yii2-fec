<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fec\controllers;

use Yii;
use yii\web\Controller;
##################################################################################################################################
# 1.在执行前，先进行module token验证，通过方可继续执行
# 2.通过controller action 自动找到对应的  o文件下的文件，文件路径和方法保持对应
# 3.函数执行完毕，返回的是json格式的数据
# 4.在返回数据之前，进行session的提交，保证修改的session提交到redis。
##################################################################################################################################
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class ModulesapiController extends Controller
{
	
	# 通过 controller action 自动找到 模块  ./o文件夹下面的文件，通过对应关系匹配
	public function actions()
    { 	
		$return = [];
		
		$module_token	= Yii::$app->request->post('module_token');
		$this_module_token = \fec\helpers\CModule::getToken();
		if($module_token != $this_module_token){
			
			$return['ack'] = false;
			$return['ack_description'] = "modules token is not right";
			$return['content'] = $module_token.'#'.$this_module_token;
			echo json_encode($return);
			exit;
		}
		$r 				= $this->getControllerAndAction();
		$t_controller 	= $r['controller'];
		$t_action 		= $r['action'];
		$current_remote_function_param_array = Yii::$app->request->post('current_remote_function_param_array');
		$current_remote_function_param_array = unserialize($current_remote_function_param_array);
		$param = (!empty($current_remote_function_param_array) && is_array($current_remote_function_param_array)  ) ?  $current_remote_function_param_array : [] ;
		$current_namespace =  $this->_name_space; 
		$module_o_dir = str_replace("\\controllers","\\o",$current_namespace);
		
		$function_exec = $module_o_dir."\\".$t_controller."::".$t_action;
		$data = \call_user_func_array($function_exec, $param);
		$data = json_decode($data);
		$return['ack'] = true;
		$return['ack_description'] = "success";
		$return['content'] = $data;
		# 把模块更新的session更新到redis上面，以供其他模块使用
		session_commit();
		echo  json_encode($return);
		exit;
    }
	# 得到当前的controller  和action
	public function getControllerAndAction(){
		$path_info = Yii::$app->request->getPathInfo();
		$path_info = trim($path_info,"/");
		$controller_str = substr($path_info,strpos($path_info,"/")+1);
		$str = strrev($controller_str);
		$action = strrev(substr($str,0,strpos($str,"/")));
		$controllerstr = strrev(substr($str,strpos($str,"/")+1));
		$controllerstr = explode("/",$controllerstr);
		$arr = [];
		$count = count($controllerstr);
		$i = 0;
		foreach($controllerstr as $v){
			$i++;
			if($count == $i){
				$arr[] = ucfirst($v);
			}else{
				$arr[] = strtolower($v);
			}
		}
		return [
			'controller' => implode("/",$arr),
			'action'	=>  $action,
		];
	}
	
	
	
	
	
	
	
	
	
	
	
}
















