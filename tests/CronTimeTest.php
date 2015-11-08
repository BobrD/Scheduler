<?php

namespace Simples\Scheduler\Tests;

use Simples\Scheduler\CronTime;

class CronTimeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Simples\Scheduler\Exception\InvalidArgumentException
     */
    public function testThrowInvalidArgumentExceptionIfGivenInvalidCronString()
    {
        $time = new CronTime();

        $time->cron('* *');
    }

    public function timeDataSet()
    {
        return [
            ['2015-12-30 22:50', '* * * * *', true],
            ['2015-12-30 22:50', '*/2 * * * *', true],
            ['2015-12-30 22:50', '*/3 * * * *', false],
            ['2015-12-30 22:50', '* */22 * * *', true],
            ['2015-12-30 22:50', '* */2 * * *', true],
            ['2015-12-30 22:50', '* */3 * * *', false],
            ['2015-12-30 22:50', '50 */3 * * *', false],
            ['2015-12-30 22:50', '5,10,15,50 * * * *', true],
        ];
    }

    /**
     * @dataProvider timeDataSet
     */
    public function testMach($date, $pattern, $expected)
    {
        $time = new CronTime($pattern);
        $date = \DateTime::createFromFormat('Y-m-d H:i', $date);

        $this->assertEquals($expected, $time->isMatch($date));
    }
}
