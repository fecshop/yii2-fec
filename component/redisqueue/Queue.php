<?php
namespace fec\component\redisqueue;
use Yii;
use yii\base\Component;
abstract class Queue extends Component
{
    /**
     * @var string Queue prefix
     */
    public $queuePrefix = 'queue';
    /** @var bool Debug mode */
    public $debug = false;
    /**
     * Builds queue prefix
     *
     * @param string|null $name Queue name
     * @return string
     */
    public function buildPrefix($name = null)
    {
        if (empty($name)) {
            $name = 'default';
        } elseif ($name && preg_match('/[^[:alnum:]]/', $name)) {
            $name = md5($name);
        }
        return $this->queuePrefix . ':' . $name;
    }
    /**
     * Push job to the queue
     *
     * @param string $job Fully qualified class name of the job
     * @param mixed $data Data for the job
     * @param string|null $queue Queue name
     * @return string ID of the job
     */
    public function push($job, $data = null, $queue = null, $options = [])
    {
        return $this->pushInternal($this->createPayload($job, $data), $queue, $options);
    }
    /**
     * Get job from the queue
     *
     * @param string|null $queue Queue name
     * @return mixed
     */
    public function pop($queue = null)
    {
        return $this->popInternal($queue);
    }
    /**
     * Create job array
     *
     * @param string $job Fully qualified class name of the job
     * @param mixed $data Data for the job
     * @return array
     */
    protected function createPayload($job, $data)
    {
        $payload = [
            'job'  => $job,
            'data' => $data
        ];
        $payload = $this->setMeta($payload, 'id', $this->getRandomId());
        return $payload;
    }
    /**
     * Set additional meta on a payload string.
     *
     * @param  string  $payload
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    protected function setMeta($payload, $key, $value)
    {
        $payload[$key] = $value;
        return json_encode($payload);
    }
    /**
     * Get random ID.
     *
     * @return string
     */
    protected function getRandomId()
    {
        return Yii::$app->security->generateRandomString();
    }
    /**
     * Get prefixed queue name
     *
     * @param $queue Queue name
     * @return string
     */
    protected function getQueue($queue)
    {
        return $this->buildPrefix($queue);
    }
    /**
     * Class-specific realisation of adding the job to the queue
     *
     * @param array $payload Job data
     * @param string|null $queue Queue name
     * @param array $options
     *
     * @return mixed
     */
    abstract protected function pushInternal($payload, $queue = null, $options = []);
    /**
     * Class-specific realisation of getting the job to the queue
     *
     * @param string|null $queue Queue name
     *
     * @return mixed
     */
    abstract protected function popInternal($queue = null);
}