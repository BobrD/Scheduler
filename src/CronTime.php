<?php

namespace Simples\Scheduler;

use Simples\Scheduler\Field\AbstractField;
use Simples\Scheduler\Field\DayOfMonthField;
use Simples\Scheduler\Field\DayOfWeekField;
use Simples\Scheduler\Field\HourField;
use Simples\Scheduler\Field\MinuteField;
use Simples\Scheduler\Field\MonthField;
use Simples\Scheduler\Exception\InvalidArgumentException;

class CronTime
{
    /**
     * @var MinuteField
     */
    private $minute;

    /**
     * @var HourField
     */
    private $hour;

    /**
     * @var DayOfMonthField
     */
    private $dayOfMonth;

    /**
     * @var MonthField
     */
    private $month;

    /**
     * @var DayOfWeekField
     */
    private $dayOfWeek;

    /**
     * @param string $cron
     */
    public function __construct($cron = '* * * * *')
    {
        $this->cron($cron);
    }

    /**
     * Задание времени запуска через строку в крон формате.
     *
     * @param string $cron
     *
     * @throws InvalidArgumentException
     */
    public function cron($cron)
    {
        $fields = explode(' ', $cron);

        if (5 !== count($fields)) {
            throw new InvalidArgumentException('Invalid cron time sting');
        }

        $this->minute = new MinuteField($fields[0]);
        $this->hour = new HourField($fields[1]);
        $this->dayOfMonth = new DayOfMonthField($fields[2]);
        $this->month = new MonthField($fields[3]);
        $this->dayOfWeek = new DayOfWeekField($fields[4]);
    }

    /**
     * @param string $minute
     *
     * @return $this
     */
    public function minute($minute)
    {
        $this->minute = new MinuteField($minute);

        return $this;
    }

    /**
     * @param string $hour
     *
     * @return $this
     */
    public function hour($hour)
    {
        $this->hour = new HourField($hour);

        return $this;
    }

    /**
     * @param string $dayOfMonth
     *
     * @return $this
     */
    public function dayOfMonth($dayOfMonth)
    {
        $this->dayOfMonth = new DayOfMonthField($dayOfMonth);

        return $this;
    }

    /**
     * @param string $month
     *
     * @return $this
     */
    public function month($month)
    {
        $this->month = new MonthField($month);

        return $this;
    }

    /**
     * @param string $dayOfWeek
     *
     * @return $this
     */
    public function dayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = new DayOfWeekField($dayOfWeek);

        return $this;
    }

    /**
     * Проверяет совпалает ли паттерн крон с времение.
     *
     * @param \DateTime|null $now
     *
     * @return bool
     */
    public function isMatch(\DateTime $now = null)
    {
        if (null === $now) {
            $now = new \DateTime();
        }

        foreach ($this->getFields() as $field) {
            if (false === $field->isMatch($now)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $pieces = [];
        foreach ($this->getFields() as $field) {
            $pieces[] = $field->toString();
        }

        return implode(' ', $pieces);
    }

    /**
     * @return array|AbstractField[]
     */
    private function getFields()
    {
        return [
            $this->minute,
            $this->hour,
            $this->dayOfMonth,
            $this->month,
            $this->dayOfWeek,
        ];
    }
}
