<?php

namespace Simples\Scheduler;

interface TaskInterface
{
    /**
     * @return CronTime
     */
    public function getCronTime();

    /**
     * @return void
     */
    public function start();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();
}
