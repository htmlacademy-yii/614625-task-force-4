<?php
namespace TaskForce\actions;

class ActionComplete extends Action{
    protected $name = 'Завершить';
    protected $internalName = 'complete';

    public static function checkVerification($customerId, $executorId, $currentId){
        if($customerId === $currentId){
            return true;
        }
        return false;
    }
}