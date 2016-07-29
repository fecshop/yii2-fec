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
##########################################################################################################################################
# CProfile 是一个中央调度器，各个模块的访问，必须通过CProfile的 fetch方法
# 1.模块如果想要被其他模块调用，必须把模块注册到CProfile，才可以使用CProfile调用
#		1.1模块注册内容：模块路径，模块api url根路径，token（选填，如果不填写，使用默认的token）。
#		1.2模块内容存放：模块的内容存放到数据库中，然后缓存到redis，要保证所有的节点都可以连接到数据库和redis，
#		   如果没有配置mysql和redis，就无法调取模块注册的信息。
# 2.在调取远程模块之前，进行数据的格式验证，和模块注册信息的验证，验证失败会抛出HTTP Exception
# 3.如果是本地访问的模块，调度器会访问模块对应的o文件下的方法。
# 4.如果访问的远程的模块，调度器会访问远程模块对应的o文件夹下面的方法。
#		4.1数据传递：1.函数方法参数，2.$_GET,$_POST 里面的参数，3.cookie的值。
#		4.2安全验证：模块的token和传递的token进行验证，验证通过，返回数据。
#		4.3在远程模块访问前，先提交session，保证session提交到redis，进而，远程模块可以访问到最新的session
#			同样，远程模块在返回数据之前，也会提交session到redis中。
# 5.CProfile 是单例模式，只能通过  CProfile::getInstance() 实例化
# 6.返回数据验证：远程返回的是json格式数据，验证数据的正确性，如果是错误信息，则会抛出HTTP Exception
# 7.JSON格式转换成数组格式
# 8. 注意：current_remote_function_param_array  不要在post 和get 中出现，这个参数被用来传递函数方法的参数。
##########################################################################################################################################
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CProfile
{
	
	//保存类实例的静态成员变量
	private static $_instance;
	 
	//private标记的构造方法
	private function __construct(){
		//echo 'This is a Constructed method;';
	}
	 
	//创建__clone方法防止对象被复制克隆
	public function __clone(){
		//trigger_error('Clone is not allow!',E_USER_ERROR);
	}
	 
	//单例方法,用于访问实例的公共的静态方法
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	# 模块间访问数据的调度方法。
	# $obj_data   =   [ $modules,$file,$function,$is_remote='false'   ];
	# $req_data	  =   [];  传递的参数
	public function fetch($obj_data,$req_data=[]){
		if(!is_array($req_data)){
			$message = 'fetch($obj_data,$req_data),$req_data must be array';
			throw new \yii\web\HttpException(406,$message);
		} 
		$data = '';
		if(is_array($obj_data) && !empty($obj_data)){
			$modules 	= $obj_data[0];
			$file 		= $obj_data[1];
			
			$function 	= $obj_data[2];
			$is_remote 	= $obj_data[3];
			if($modules && $file && $function){
				$ModulesConfig = $this->getModulesConfig();
				if(isset($ModulesConfig[$modules])){
					$moduleConfig = $ModulesConfig[$modules];
					if($is_remote){
						# 远程 
						# 把模块更新的session更新到redis上面，以供其他模块使用
						session_commit();
						$data = $this->getRemotePostData($modules,$moduleConfig,$file,$function,$req_data,$timeout = 20);
					}else{
						# 本地
						$file   = str_replace("/","\\",$file);
						$function_exec = $moduleConfig['moduleDir']."\\o\\".$file;
						$function_exec .= "::".$function;
						$data = \call_user_func_array($function_exec,$req_data);
						$data = CFunc::object_to_array(json_decode($data));
					}
				}else{
					$message = "!! Get Data From Local Module <$modules> Error: Module is not config in Profile.";
					throw new \yii\web\HttpException(406,$message);
					
					
		
				}
			}else{
				$message = "!! Get Data From Local Module <$modules> Error: param:obj_data must is array and count >= 3.";
				throw new \yii\web\HttpException(406,$message);
				
			}
		}else{
			$message = "!! Get Data From Local Module <$modules> Error: param:obj_data is Empty OR is not Array .";
			throw new \yii\web\HttpException(406,$message);
			
			
		}
		return $data;
	}
	
	
	
	public function getDefaultToken(){
		return CConfig::getDefaultModuleToken();
	}
	
	# 得到模块的配置
	public function getModulesConfig(){
		return [
			
			'DMenu' => [
							'moduleDir' =>'\appdata\code\Blog\DMenu',
							'apiurl'  =>'http://120.24.37.249:100/dmenu',
							'token'  =>'xxxxxx',
						],	
		];
		
	}
	
	# 得到远程模块信息
	public function getRemotePostData($modules,$moduleConfig,$file,$function,$req_data=[],$timeout = 20){
		$file = str_replace("\\","/",$file);
		$url 	= strtolower(trim($moduleConfig['apiurl']."/".$file."/".$function));
		$module_token 	= $moduleConfig['token'] ? $moduleConfig['token'] : $this->getDefaultToken();
		$post 	= Yii::$app->request->post() ;
		$get 	= Yii::$app->request->get();
		$post 	= $post ? $post : [];
		$get 	= $get ? $get : [];
		$data   = array_merge($get , $post); 
		$data['module_token'] = $module_token;	
		$data['current_remote_function_param_array'] = serialize($req_data);
		$arr = '';
		//var_dump($_COOKIE);exit;
		if(is_array($_COOKIE)){
			foreach($_COOKIE as $k=>$v){
				$arr[]  = $k."=".urlencode($v);
			}
		}
		if(!empty($arr)){
			$strCookie = implode(";",$arr);
		}
		//对空格进行转义
		$url = str_replace(' ','+',$url);
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if($strCookie){
			curl_setopt( $ch, CURLOPT_COOKIE, $strCookie ); 
		}
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);  
		// POST数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// 把post的变量加上
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//执行并获取url地址的内容
		$output = curl_exec($ch);
		//echo $output ;
		//释放curl句柄
		curl_close($ch);
		//var_dump($data['current_remote_function_param_array']);
		//var_dump($_COOKIE);
		//echo "<br/><br/>";
		//var_dump($output);
		//echo $url;
		//exit;
		//$return['ack'] = true;
		//$return['ack_description'] = "success";
		//$return['content'] = $data;
		$return = CFunc::object_to_array(json_decode($output));
		if($return['ack']){
			return $return['content'];
		}else{
			$message = "Get Data From Remote Module <$modules> Error:".$return['ack_description'].".";
			throw new \yii\web\HttpException(400,$message);
			
		}
		//return $output;
		
        
    
	}
}








