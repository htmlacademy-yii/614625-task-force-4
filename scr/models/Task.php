<?php

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_WORKING = 'working';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const ACTION_START = 'start';
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_FAIL = 'fail';
    const ACTION_COMPLETE = 'complete';

    public $status;
    public $customerId;
    public $executorId;

    public function __construct($status, $customerId, $executorId = null){
        $this->status = $status;
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    public function getActions( $currentUserId){
        if ($currentUserId === $customerId && $this->status === self::STATUS_NEW){
            return self::ACTION_CANCEL;
        }
        if ($currentUserId !== $customerId && $this->status === self::STATUS_NEW){
            return self::ACTION_RESPOND;
        }
        if ($this->status === self::STATUS_CANCELED){
            return null;
        }
        if ($currentUserId === $customerId && $this->status === self::STATUS_WORKING){
            return self::ACTION_COMPLETE;
        }
        if ($currentUserId !== $customerId && $this->status === self::STATUS_WORKING){
            return [self::ACTION_COMPLETE, self::ACTION_CANCEL];
        }
        if ($this->status === self::STATUS_COMPLETED){
            return null;
        }
        if ($this->status === self::STATUS_FAILED){
            return null;
        }
    }

    public function getStatus($action){
        if ($action === self::ACTION_START){
            return self::STATUS_NEW;
        }
        if ($action === self::ACTION_CANCEL){
            return self::STATUS_CANCELED;
        }
        if ($action === self::ACTION_RESPOND){
            return self::STATUS_WORKING;
        }
        if ($action === self::ACTION_FAIL){
            return self::STATUS_FAILED;
        }
        if ($action === self:: ACTION_COMPLETE){
            return self::STATUS_COMPLETED;
        }
    }
}
