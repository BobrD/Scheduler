<?php

namespace Simples\Scheduler\Tests;

use Simples\Scheduler\Scheduler;
use Simples\Scheduler\TaskInterface;
use Simples\Scheduler\TaskSubscriberInterface;

class SchedulerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddSubscriber()
    {
        $taskSubscriber = $this->getMock(TaskSubscriberInterface::class);
        $task = $this->getMock(TaskInterface::class);

        $scheduler = new Scheduler();

        $scheduler->addSubscriber($taskSubscriber);

        $taskSubscriber
            ->expects($this->once())
            ->method('getTasks')
            ->willReturn([$task]);

        $tasks = $scheduler->getTasks();

        $this->assertCount(1, $tasks);

        $this->assertEquals($task, $tasks[0]);
    }
}

