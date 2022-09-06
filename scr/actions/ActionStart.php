<?php
namespace TaskForce\actions;

class ActionStart extends Action{
    protected $name = 'Начать';
    protected $internalName = 'start';

    public static function checkVerification($customerId, $executorId, $currentId){
        if($customerId === $currentId){
            return true;
        }
        return false;
    }
}