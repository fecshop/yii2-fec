<?php
namespace fec\component\redisqueue;
use Yii;
class Job
{
    protected $queueObject;
    protected $payload;
    protected $queueName;
    public function __construct($queueObject, $payload, $queueName)
    {
        $this->queueObject = $queueObject;
        $this->payload = $payload;
        $this->queueName = $queueName;
    }
    public function run()
    {
        $this->resolveAndRun(json_decode($this->payload, true));
    }
    public function getQueueObject()
    {
        return $this->queueObject;
    }
    protected function resolveAndRun(array $payload)
    {
        list($class, $method) = $this->resolveJob($payload['job']);
        $instance = Yii::createObject([
            'class' => $class
        ]);
        $instance->{$method}($this, $payload['data']);
    }
    protected function resolveJob($job)
    {
        $segments = explode('@', $job);
        return count($segments) > 1 ? $segments : array($segments[0], 'run');
    }
}