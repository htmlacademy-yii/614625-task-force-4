<?php
namespace TaskForce\exceptions;

use Exception;

class ActionException extends Exception{
    protected $message = 'Для данного действия нет статуса';
}