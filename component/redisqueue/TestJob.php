<?php
namespace fec\component\redisqueue;

class TestJob
{
    public function run($job, $data)
    {
        //process $data;
        var_dump($data);
    }
} 