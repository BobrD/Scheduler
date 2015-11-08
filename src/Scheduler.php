<?php

namespace Simples\Scheduler;

use Simples\Scheduler\TaskInterface;
use Simples\Scheduler\TaskSubscriber;

class Scheduler
{
    /**
     * @var TaskSubscriberInterface[]
     */
    private $taskSubscribers;

    /**
     * @param TaskSubscriberInterface $taskSubscriber
     */
    public function addSubscriber(TaskSubscriberInterface $taskSubscriber)
    {
        $this->taskSubscribers[] = $taskSubscriber;
    }

    /**
     * Запуск крона
     */
    public function run()
    {
        $now = new \DateTime();

        foreach ($this->getTasks() as $task) {
            if ($task->getCronTime()->isMatch($now)) {
                $this->runInSubProcess($task);
            }
        }
    }

    /**
     * @param string $name
     */
    public function runWithName($name)
    {
        foreach ($this->getTasks() as $task) {
            if ($name === $task->getName()) {
                $this->runInSubProcess($task);
            }
        }
    }

    /**
     * @return array|TaskInterface[]
     */
    public function getTasks()
    {
        $tasks = [];
        foreach ($this->taskSubscribers as $subscriber) {
            foreach ($subscriber->getTasks() as $task) {
                $tasks[] = $task;
            }
        }

        return $tasks;
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    private function runInSubProcess(TaskInterface $task)
    {
        if (!function_exists('pcntl_fork')) {
            $task->start();
            return;
        }

        $pid = pcntl_fork();

        if ($pid === -1) {
            // Зупускаем задачу в текущем потоке если не смогли создать форк
            $task->start();
        } else if ($pid) {
            // Родитель
        } else {
            $task->start();
        }
    }
}
