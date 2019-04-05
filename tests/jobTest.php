<?php
namespace YuK1\Tests;

use \YuK1\{Job, Task};

class JobTest extends \PHPUnit\Framework\TestCase
{
    public function testTest()
    {
        $job = new Job();

        for ($i = 0 ; $i < 10 ; $i++) {
            $priority = rand(0, 5);

            $job->add(new Task(function() use($i) {
                printf("Hello number '%d'!" . PHP_EOL, $i);
            }, $priority, $priority > 0 ? sprintf('My priority is %d.', $priority) : null));
        }

        $job->run();
    }
}