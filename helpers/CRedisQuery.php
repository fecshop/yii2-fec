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
use yii\base\InvalidConfigException;
use yii\redis\Connection;
use fec\helpers\credisqueue\Queue;
use fec\helpers\credisqueue\Job;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CRedisQueue extends Queue
{
	/*
	在使用之前，您需要先进行配置如下：
	'components' => [
		'queue' => [
			'class' => 'fec\component\RedisQueue',
		],
	],
	
	'controllerMap' => [
        'queue' => 'fec\component\redisqueue\QueueController'
    ],
	
	
	*/
	/*
		1. 定义TestJob文件
		   实现run方法()
		2. 执行命令行：./yii queue/listen MyTestQueue
		3. 使用push方法，把参数传入
		$job = '\fec\component\redisqueue\TestJob';
		$data = ['a', 'b', 'c'];
		$queue  = 'MyTestQueue';
		CRedisQuery::push($job,$data);
		
		\fec\component\redisqueue\TestJob 里面的run方法将会被执行
	
	*/
	public static function push($job,$data,$queue = null){
		//return  Yii::$app->queue->push('\fec\component\redisqueue\TestJob', ['a', 'b', 'c']);
		return  Yii::$app->queue->push($job,$data,$queue);
		
	}
} 