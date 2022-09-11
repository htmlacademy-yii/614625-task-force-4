<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionCancel extends AbstractAction{
    protected string $name = 'Отменить';
    protected string $internalName = 'cancel';

    public static function checkVerification(Task $task, int $currentId) : bool
    {
        return false;
    }
}