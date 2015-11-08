<?php

namespace Simples\Scheduler\Tests\Functional\Fixtures;

use Simples\Scheduler\CronTime;
use Simples\Scheduler\TaskInterface;

class BadTask implements TaskInterface
{    public function __construct()
    {
    }

    public function getCronTime()
    {
        return new CronTime('* * * * *');
    }

    public function start()
    {
        throw new \RuntimeException();
    }

    public function getName()
    {
        return 'bad task';
    }

    public function getDescription()
    {
        return 'description';
    }
}
