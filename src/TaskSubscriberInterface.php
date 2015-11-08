<?php

namespace Simples\Scheduler;

interface TaskSubscriberInterface
{
    /**
     * @return TaskInterface[]
     */
    public function getTasks();
}