<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionFail extends AbstractAction{
    protected string $name = 'Провалить';
    protected string $internalName = 'fail';

    public static function checkVerification(Task $task, int $currentId) : bool
    {
        if($task->executorId === $currentId && $task->status === Task::STATUS_FAILED)
        {
            return true;
        }
        return false;
    }
}