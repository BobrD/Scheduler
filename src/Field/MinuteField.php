<?php

namespace Simples\Scheduler\Field;

class MinuteField extends AbstractField
{
    public function getTime(\DateTime $dateTime)
    {
        return intval($dateTime->format('i'));
    }

    /**
     * @return int
     */
    protected function getLowerBoundary()
    {
        return 0;
    }

    /**
     * @return int
     */
    protected function getUpperBoundary()
    {
        return 59;
    }
}
