<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

abstract class Action
{   
    protected $name;
    protected $internalName;

    public function getName(){
        return $this->name;
    }

    public function getInternalName(){
        return $this->internalName;
    }

    abstract public static function checkVerification($customerId, $executorId, $currentId);
}