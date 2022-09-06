<?php
namespace TaskForce\actions;

class ActionCancel extends Action{
    protected $name = 'Отменить';
    protected $internalName = 'cancel';

    public static function checkVerification($customerId, $executorId, $currentId){
        if($customerId === $currentId){
            return true;
        }
        return false;
    }
}