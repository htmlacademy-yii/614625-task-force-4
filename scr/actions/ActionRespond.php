<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionRespond extends AbstractAction{
    protected string $name = 'Откликнуться';
    protected string $internalName = 'respond';

    public static function checkVerification(Task $task, int $currentId) :bool
    {
        if($currentId === $task->customerId){
            return false;
        }
        return $currentId && $task->status === Task::STATUS_NEW;
    }
}
