<?php
namespace TaskForce\exceptions;

use Exception;

class PrivilegeException extends Exception{
    protected $message ='Роль пользователя задана неверно';
}
