<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fec\component;
use Yii;
use yii\base\InvalidConfigException;
use yii\redis\Connection;
use fec\component\redisqueue\Queue;
use fec\component\redisqueue\Job;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class RedisQueue extends Queue
{
	
	/**
	 *   'queue' => [
     *       'class' => 'fec\component\RedisQueue',
     *   ],
	 *
	 */
	
    /**
     * @var string Default redis component name
     */
    public $redis = 'redis';
    /**
     * Class initialization logic
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (is_string($this->redis)) {
            $this->redis = Yii::$app->get($this->redis);
        } elseif (is_array($this->redis)) {
            $this->redis = Yii::createObject($this->redis);
        }
        if (!$this->redis instanceof Connection) {
            throw new InvalidConfigException("Queue::redis must be either a Redis connection instance or the application component ID of a Redis connection.");
        }
    }
    protected function pushInternal($payload, $queue = null, $options = [])
    {
        $this->redis->rpush($this->getQueue($queue), $payload);
        $payload = json_decode($payload, true);
        return $payload['id'];
    }
    public function popInternal($queue = null)
    {
        $payload = $this->redis->lpop($this->getQueue($queue));
        if ($payload) {
            //$this->redis->zadd($queue.':reserved', $this->getTime() + 60, $job);
            return new Job($this, $payload, $queue);
        }
        return null;
    }
} 