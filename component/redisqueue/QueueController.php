<?php
namespace fec\component\redisqueue;
use Yii;
use yii\console\Controller;
/**
 * Queue Process Command
 *
 * Class QueueController
 * @package wh\queue\console\controllers
 */
class QueueController extends Controller
{
    private $timeout;
    private $sleep=5;
    /**
     * Process a job
     *
     * @param string $queueName
     * @param string $queueObjectName
     * @throws \Exception
     */
    public function actionWork($queueName = null, $queueObjectName = 'queue')
    {
        $this->process($queueName, $queueObjectName);
    }
    /**
     * Continuously process jobs
     *
     * @param string $queueName
     * @param string $queueObjectName
     * @throws \Exception
     */
    public function actionListen($queueName = null, $queueObjectName = 'queue')
    {
        while (true) {
            if ($this->timeout !==null) {
                if ($this->timeout<time()) {
                    return true;
                }
            }
            if (!$this->process($queueName, $queueObjectName)) {
                sleep($this->sleep);
            }
        }
    }
    protected function process($queueName, $queueObjectName)
    {
        $queue = Yii::$app->{$queueObjectName};
        $job = $queue->pop($queueName);
        if ($job) {
            try {
                $job->run();
                return true;
            } catch (\Exception $e) {
                if ($queue->debug) {
                    var_dump($e);
                }
                Yii::error($e->getMessage(), __METHOD__);
            }
        }
        return false;
    }
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (getenv('QUEUE_TIMEOUT')) {
            $this->timeout=(int)getenv('QUEUE_TIMEOUT')+time();
        }
        if (getenv('QUEUE_SLEEP')) {
            $this->sleep=(int)getenv('QUEUE_SLEEP');
        }
        return true;
    }
}