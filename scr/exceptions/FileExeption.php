<?php
namespace TaskForce\exceptions;

use Exception;

class FileExeption extends Exception{
    protected $message = 'Такого файла не существует';
}
