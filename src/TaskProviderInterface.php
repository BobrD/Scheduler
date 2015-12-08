<?php

namespace Simples\Scheduler;

/**
 * Предоставляет возможность запускать задачи из разных источников.
 */
interface TaskProviderInterface
{
    /**
     * @return TaskInterface[]
     */
    public function getTasks();
}
