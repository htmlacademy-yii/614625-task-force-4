<?php
namespace TaskForce\actions;

use TaskForce\models\Task;

class ActionFail extends AbstractAction{
    protected string $name = 'Провалить';
    protected string $internalName = 'fail';

    public static function checkVerification(Task $task, int $currentId) : bool
    {
        return false;
    }
}