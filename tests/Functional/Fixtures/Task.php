<?php

namespace Simples\Scheduler\Tests\Functional\Fixtures;

use Simples\Scheduler\CronTime;
use Simples\Scheduler\TaskInterface;

class Task implements TaskInterface
{
    /**
     * @var string
     */
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getCronTime()
    {
        return new CronTime('* * * * *');
    }

    public function start()
    {
        fclose(fopen($this->fileName, 'w+'));
    }

    public function getName()
    {
        return 'task';
    }

    public function getDescription()
    {
        return 'description';
    }
}
