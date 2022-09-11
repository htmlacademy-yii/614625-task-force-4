<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionStart extends AbstractAction{
    protected string $name = 'Начать';
    protected string $internalName = 'start';

    public static function checkVerification(Task $task, int $currentId) : bool
    {   
        return $task->customerId === $currentId && $task->status === Task::STATUS_NEW;
    }
}