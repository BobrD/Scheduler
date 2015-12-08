<?php

namespace Simples\Scheduler\Tests\Unit;

use Simples\Scheduler\Scheduler;
use Simples\Scheduler\TaskInterface;
use Simples\Scheduler\TaskProviderInterface;

class SchedulerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddSubscriber()
    {
        $taskProviderA = $this->getMock(TaskProviderInterface::class);
        $taskA = $this->getMock(TaskInterface::class);


        $taskSubscriberB = $this->getMock(TaskProviderInterface::class);
        $taskB = $this->getMock(TaskInterface::class);

        $taskProviderA
            ->expects($this->once())
            ->method('getTasks')
            ->willReturn([$taskA]);

        $taskSubscriberB
            ->expects($this->once())
            ->method('getTasks')
            ->willReturn([$taskB]);

        $scheduler = new Scheduler();

        $scheduler->addProvider($taskProviderA);
        $scheduler->addProvider($taskSubscriberB);


        $tasks = $scheduler->getTasks();

        $this->assertCount(2, $tasks);
    }
}
