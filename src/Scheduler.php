<?php

namespace Simples\Scheduler;

class Scheduler
{
    /**
     * @var TaskProviderInterface[]
     */
    private $taskSubscribers;

    /**
     * @param TaskProviderInterface $taskProvider
     */
    public function addProvider(TaskProviderInterface $taskProvider)
    {
        $this->taskSubscribers[] = $taskProvider;
    }

    /**
     * Запуск крона.
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
     *
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
        } elseif (0 === $pid) {
            try {
                $task->start();
            } catch (\Exception $e) {}

            exit;
        }
    }
}
