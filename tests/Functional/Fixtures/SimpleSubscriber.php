<?php

namespace Simples\Scheduler\Tests\Functional\Fixtures;

use Simples\Scheduler\TaskInterface;
use Simples\Scheduler\TaskSubscriberInterface;

class SimpleSubscriber implements TaskSubscriberInterface
{
    private $tasks = [];

    public function addTask(TaskInterface $task)
    {
        $this->tasks[] = $task;
    }

    public function getTasks()
    {
        return $this->tasks;
    }
}
