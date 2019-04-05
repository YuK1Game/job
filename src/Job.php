<?php
namespace YuK1;

use YuK1\Task;

use Symfony\Component\Console\Helper\ProgressBar as SymfonyProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Job
{
    /**
     * @var Collect Tasks list
     */
    protected $_tasks = null;

    /**
     * @var callable Pre-Run action
     */
    protected $_pre_run = null;

    /**
     * @var callable Post-Run action
     */
    protected $_post_run = null;

    /**
     * @var float Progress time
     */
    protected $_progress_time = null;

    /**
     * @var Symfony\Component\Console\Helper\ProgressBar
     */
    protected $_progress_bar = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->_tasks = collect();
    }

    /**
     * Create this instance
     * 
     * @return YuK1\Job
     */
    public static function instance() {
        return new self();
    }

    /**
     * Add Task
     * 
     * @param YuK1\Task $task
     */
    public function add(...$tasks) {
        foreach ($tasks as $task) {
            $this->_tasks->push($task);
        }
    }

    /**
     * Execute all tasks
     */
    public function run() {
        $this->pre_run();
        $this->tasks()->each(function(Task $task) {
            $this->advance($task);
        });
        $this->post_run();
    }

    /**
     * Init SymfonyProgressBar
     * 
     * @return void
     */
    protected function init_progress_bar() : void {
        $this->_progress_bar = new SymfonyProgressBar(new ConsoleOutput());
        $this->_progress_bar->setMaxSteps($this->count());
        $this->_progress_time = microtime(true);
    }

    /**
     * Pre run action
     * 
     * @return void
     */
    protected function pre_run() : void {
        if (is_callable($this->_pre_run)) {
            $callable = $this->_pre_run;
            $callable();
        }

        $this->init_progress_bar();
    }

    /**
     * Advance task
     * 
     * @return void
     */
    protected function advance(Task $task) {
        if ($task->has_message()) {
            $this->_progress_bar->setFormat("%current%/%max% [%bar%] %percent:3s%% (%estimated:-6s% / %memory:6s%) - %message%");
            $this->_progress_bar->setMessage($task->get_message());
        } else {
            $this->_progress_bar->setFormat("%current%/%max% [%bar%] %percent:3s%% (%estimated:-6s% / %memory:6s%)");
        }

        $task->execute();

        $this->_progress_bar->advance();
    }

    /**
     * Post run action
     * 
     * @return void
     */
    protected function post_run() {
        $this->_progress_bar->finish();
        $total_time = microtime(true) - $this->_progress_time;

        if (is_callable($this->_post_run)) {
            $callable = $this->_post_run;
            $callable($total_time);
        }
    }

    /**
     * @return int Task Count
     */
    public function count() {
        return $this->_tasks->count();
    }

    /**
     * Get sorted tasks
     * 
     * @return Collect Tasks
     */
    public function tasks() {
        return $this->_tasks->sortBy(function(Task $task) {
            $priority = $task->get_priority();
            return is_numeric($priority) ? $priority : 65535;
        });
    }

    /**
     * Merge job tasks
     * 
     * @param Job
     * @param int overwrite priority
     * @return $this
     */
    public function merge(Job $job, int $priority = null) {
        $job->tasks()->each(function(Task $task) use($priority) {
            if ($priority !== null) {
                $task->set_priority($priority);
            }
            $this->add($task);
        });
        return $this;
    }

}