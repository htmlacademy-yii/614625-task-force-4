<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionComplete extends AbstractAction{
    protected string $name = 'Завершить';
    protected string $internalName = 'complete';

    public static function checkVerification(Task $task, int $currentId) : bool
    {
        return $task->customerId === $currentId && $task->status === Task::STATUS_WORKING;
    }
}