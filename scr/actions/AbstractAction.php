<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

abstract class AbstractAction
{   
    protected string $name;
    protected string $internalName;

    public function getName() : string
    {
        return $this->name;
    }

    public function getInternalName() : string
    {
        return $this->internalName;
    }

    abstract public static function checkVerification(Task $task, int $currentId): bool;
}