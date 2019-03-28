<?php
namespace YuK1;

class Task
{
    protected $_action = null;

    protected $_priority = null;

    protected $_message = null;

    public function __construct(callable $action, int $priority = 0, string $message) {
        $this->_action = $action;
        $this->_priority = $priority;
        $this->_message = $message;
    }

    public function set_priority(int $priority) {
        $this->_priority = $priority;
    }

    public function set_message(string $message) {
        $this->_message = $message;
    }

}