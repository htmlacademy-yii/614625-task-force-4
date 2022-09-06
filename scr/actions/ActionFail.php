<?php
namespace TaskForce\actions;

class ActionFail extends Action{
    protected $name = 'Провалить';
    protected $internalName = 'fail';

    public static function checkVerification($customerId, $executorId, $currentId){
        if($executorId === $currentId){
            return true;
        }
        return false;
    }
}