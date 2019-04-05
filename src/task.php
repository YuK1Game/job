<?php
namespace YuK1;

class Task
{
    /**
     * @var callable Action method
     */
    protected $_action = null;

    /**
     * @var int Priority
     */
    protected $_priority = null;

    /**
     * @var string Message
     */
    protected $_message = null;

    /**
     * Constructor
     * 
     * @param callable Action function
     * @param int priority
     * @param string message
     */
    public function __construct(callable $action, int $priority = null, string $message = null) {
        $this->_action = $action;
        $this->_priority = $priority;
        $this->_message = $message;
    }

    public function set_priority(int $priority) {
        $this->_priority = $priority;
    }

    public function get_priority() {
        return $this->_priority;
    }

    public function set_message(string $message) {
        $this->_message = $message;
    }

    public function get_message() {
        return $this->_message;
    }

    public function has_message() {
        return !! $this->get_message();
    }

    public function execute() {
        $callable = $this->_action;
        $callable();
    }

}