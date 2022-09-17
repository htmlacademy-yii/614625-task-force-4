<?php
namespace TaskForce\exceptions;

class ActionException extends TaskException{
    protected $message;
    public function errorMessage($message){
        echo $message;
        exit;
    }
}