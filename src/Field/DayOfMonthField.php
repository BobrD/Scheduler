<?php

namespace Simples\Scheduler\Field;

class DayOfMonthField extends AbstractField
{
    /**
     * @return int
     */
    protected function getLowerBoundary()
    {
        return 1;
    }

    /**
     * @return int
     */
    protected function getUpperBoundary()
    {
        return 31;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return int
     */
    public function getTime(\DateTime $dateTime)
    {
        return intval($dateTime->format('d'));
    }
}
