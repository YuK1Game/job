Job
====

## Description

Task management tool for tracking the progress of multiple tasks on the command line.

## Usage

```php
require_once('vendor/autoload.php');

use YuK1\{Job, Task};

$job = new Job();

$task1 = new Task(function() { echo 'Task 1'; }, 3, 'Task 1 runnning.');
$task2 = new Task(function() { echo 'Task 2'; }, 2, 'Task 2 runnning.');
$task3 = new Task(function() { echo 'Task 3'; }, 1, 'Task 3 runnning.');

$job->add($task1, $task2, $task3);
$job->run();

```

## Install

`composer require yuk1/job`

## Test

`composer test tests`

## Author

[YuK1Game](https://github.com/yuk1game)