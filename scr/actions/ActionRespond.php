<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionRespond extends AbstractAction{
    protected string $name = 'Откликнуться';
    protected string $internalName = 'respond';

    public static function checkVerification(Task $task, int $currentId) :bool
    {
        if($task->executorId === $currentId && $task->status === Task::STATUS_NEW)
        {
            return true;
        }
        return false;
    }
}