<?php
namespace TaskForce\models;

use TaskForce\actions\ActionStart;
use TaskForce\actions\ActionCancel;
use TaskForce\actions\ActionRespond;
use TaskForce\actions\ActionFail;
use TaskForce\actions\ActionComplete;
use TaskForce\exceptions\StatusException;
use TaskForce\exceptions\PrivilegeException;
use TaskForce\exceptions\ActionException;

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

    public function __construct(string $status, int $customerId, ?int $executorId = null){
        try {
            if(!array_search($status,[self::STATUS_NEW, self::STATUS_CANCELED, self::STATUS_WORKING, self::STATUS_COMPLETED, self::STATUS_FAILED])){
                throw new StatusException("Статус задан неверно");
            }
            if($customerId === null || !is_int($customerId)){
                throw new PrivilegeException("Заказчик задан неверно");
            }
            if(!is_int($executorId)){
                throw new PrivilegeException("Исполнитель задан неверно");
            }
            if($customerId === $executorId){
                throw new PrivilegeException("Заказчик и исполнитель не могут быть одинаковыми");
            }
            $this->status = $status;
            $this->customerId = $customerId;
            $this->executorId = $executorId;
        }
        catch (StatusException $e){
            $e->errorMessage($e);
        }
        catch (PrivilegeException $e){
            $e->errorMessage($e);
        }
    }

    public function getActions(int $currentId){
        $actions = [];
        if(ActionStart::checkVerification($this, $currentId)){
            $actions[] = new ActionStart;
        }
        if(ActionCancel::checkVerification($this, $currentId)){
            $actions[] = new ActionCancel;
        }
        if(ActionRespond::checkVerification($this, $currentId)){
            $actions[] = new ActionRespond;
        }
        if(ActionFail::checkVerification($this, $currentId)){
            $actions[] = new ActionFail;
        }
        if(ActionComplete::checkVerification($this, $currentId)){
            $actions[] = new ActionComplete;
        }
        return $actions;
    }

    public function getStatus(string $action){
        try{
            if(!array_search($action,[self::ACTION_START,self::ACTION_CANCEL,self::ACTION_RESPOND,self::ACTION_FAIL,self:: ACTION_COMPLETE])){
                throw new ActionException("Для данного действия нет статуса");
            }
        }
        catch(ActionException $e){
            $e->errorMessage($e);
        }
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
