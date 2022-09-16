<?php
namespace TaskForce\exceptions;

class PrivilegeException extends TaskException{
    protected $message;
    public function errorMessage($message){
        echo $message;
        exit;
    }
}
