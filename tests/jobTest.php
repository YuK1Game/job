<?php
namespace YuK1\Tests;

use \YuK1\{Job, Task};

class JobTest extends \PHPUnit\Framework\TestCase
{
    public function testTest()
    {
        $job = new Job();

        $task1 = new Task(function() { echo 'Task 1'; }, 3, 'Task 1 runnning.');
        $task2 = new Task(function() { echo 'Task 2'; });
        $task3 = new Task(function() { echo 'Task 3'; }, 1, 'Task 3 runnning.');
        
        $job->add($task1, $task2, $task3);
        $job->run();
    }
}