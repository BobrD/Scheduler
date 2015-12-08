<?php

namespace Simples\Scheduler\Tests\Functional;

use Simples\Scheduler\Scheduler;
use Simples\Scheduler\Tests\Functional\Fixtures\BadTask;
use Simples\Scheduler\Tests\Functional\Fixtures\SimpleProvider;
use Simples\Scheduler\Tests\Functional\Fixtures\Task;

class SchedulerTest extends \PHPUnit_Framework_TestCase
{
    private $tmpDir;

    protected function setUp()
    {
        $dir = __DIR__.'/tmp';
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $this->tmpDir = $dir;
    }

    public function testRun()
    {
        $scheduler = new Scheduler();

        $subscriber = new SimpleProvider();

        $subscriber->addTask(new Task($firstFile = $this->tmpDir.'/1'));
        $subscriber->addTask(new Task($secondFile = $this->tmpDir.'/2'));

        $scheduler->addProvider($subscriber);

        $scheduler->run();

        // Запуск происходит асинхронно, ждём
        sleep(1);

        $this->assertFileExists($firstFile);
        $this->assertFileExists($secondFile);
        $this->assertEquals(2, iterator_count(new \FilesystemIterator($this->tmpDir)));
    }

    public function testTaskRunningInSeparateProcess()
    {
        $scheduler = new Scheduler();

        $subscriber = new SimpleProvider();

        $subscriber->addTask(new BadTask());
        $subscriber->addTask(new Task($firstFile = $this->tmpDir.'/1'));

        $scheduler->addProvider($subscriber);

        $scheduler->run();

        // Запуск происходит асинхронно, ждём
        sleep(1);

        $this->assertFileExists($firstFile);
    }

    protected function tearDown()
    {
        foreach (new \DirectoryIterator($this->tmpDir) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }

            unlink($fileInfo->getPathname());
        }

        rmdir($this->tmpDir);
    }
}
