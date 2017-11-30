<?php

class Task extends Entity {

    public $id, $task, $priority, $size, $group, $deadline, $status, $flag;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($value)
    {
        if($value < 0) {
            $this->id = false;
            return false;
        }
        $this->id = $value;
        return true;
    }

    public function setTask($value)
    {
        if(!ctype_alpha(str_replace(' ', '', $value)) || strlen($value) >= 64) {
            return false;
        }
        $this->task = $value;
        return true;
    }

    public function setPriority($value)
    {
        if(!is_numeric($value) || $value < 1 || $value >= 4) {
            return false;
        }
        $this->priority = $value;
        return true;
    }

    public function setSize($value)
    {
        if(!is_numeric($value) || $value < 1 || $value >= 4) {
            return false;
        }
        $this->size = $value;
        return true;
    }

    public function setGroup($value)
    {
        if(!is_numeric($value) || $value < 1 || $value >= 5) {
            return false;
        }
        $this->group = $value;
        return true;
    }

    public function setDeadline($value)
    {
        $this->deadline = $value;
        return true;
    }

    public function setStatus($value)
    {
        $this->status = $value;
        return true;
    }

    public function setFlag($value)
    {
        $this->flag = $value;
        return true;
    }
}
