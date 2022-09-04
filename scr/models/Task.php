<?php
namespace TaskForce\models;

abstract class Action
{
    abstract public function actionStart();

    abstract public function actionCancel();

    abstract public function actionRespond();

    abstract public function actionFail();

    abstract public function actionComplete();
}

class FilledAction extends Action
{
    public function actionStart()
    {

    }
    public function actionCancel()
    {

    }
    public function actionRespond()
    {

    }
    public function actionFail()
    {

    }
    public function actionComplete()
    {

    }
}

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

    public function getActions($currentUserId){
        switch ($this->status){
            case self::STATUS_NEW:
                if ($currentUserId === $this->customerId){
                    return [self::ACTION_CANCEL, self::ACTION_START];
                }
                return [self::ACTION_RESPOND];
            case self::STATUS_CANCELED:
                return [];
            case self::STATUS_WORKING:
                if ($currentUserId === $this->customerId ){
                    return [self::ACTION_COMPLETE];
                }
                if ($currentUserId === $this->executorId){
                    return [self::ACTION_FAIL];
                }
                return [];
            return [];
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
