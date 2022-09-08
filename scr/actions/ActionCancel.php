<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionCancel extends AbstractAction{
    protected string $name = 'Отменить';
    protected string $internalName = 'cancel';

    public static function checkVerification(Task $task, int $currentId) : bool
    {
        if($task->customerId === $currentId && $task->status === Task::STATUS_CANCELED)
        {
            return true;
        }
        return false;
    }
}