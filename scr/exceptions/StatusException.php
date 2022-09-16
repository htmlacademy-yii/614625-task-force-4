<?php
namespace TaskForce\exceptions;

class StatusException extends TaskException{
    protected $message;
    public function errorMessage($message){
        echo $message;
        exit;
    }
}
