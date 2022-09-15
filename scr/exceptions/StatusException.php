<?php
namespace TaskForce\exceptions;

class StatusException extends TaskException{
    const STATUSES = [self::STATUS_NEW, self::STATUS_CANCELED, self::STATUS_WORKING, self::STATUS_COMPLETED, self::STATUS_FAILED];
    if(!in_array($this->status, STATUSES)){
        echo 'sa';
    }
}