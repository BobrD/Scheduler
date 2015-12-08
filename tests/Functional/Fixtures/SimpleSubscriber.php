<?php

namespace Simples\Scheduler\Tests\Functional\Fixtures;

use Simples\Scheduler\TaskInterface;
use Simples\Scheduler\TaskProviderInterface;

class SimpleProvider implements TaskProviderInterface
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
