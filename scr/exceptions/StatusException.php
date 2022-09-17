<?php
namespace TaskForce\exceptions;

use Exception;

class StatusException extends Exception{
    protected $message = 'Статус задан неверно';
}
