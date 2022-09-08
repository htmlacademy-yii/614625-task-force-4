<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionStart extends AbstractAction{
    protected string $name = 'Начать';
    protected string $internalName = 'start';

    public static function checkVerification(Task $task, int $currentId) : bool
    {   
        if($task->customerId === $currentId && $task->status === Task::STATUS_NEW)
        {
            return true;
        }
        return false;
    }
}