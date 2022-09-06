<?php
namespace TaskForce\actions;

class ActionRespond extends Action{
    protected $name = 'Откликнуться';
    protected $internalName = 'respond';

    public static function checkVerification($customerId, $executorId, $currentId){
        if($customerId === $currentId){
            return true;
        }
        return false;
    }
}