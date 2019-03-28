<?php
namespace YuK1;

use YuK1\Task;

use Symfony\Component\Console\Helper\ProgressBar as SymfonyProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Job
{
    public function __construct() {
        echo "Hello package!";
    }
}