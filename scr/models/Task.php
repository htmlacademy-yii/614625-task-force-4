<?php

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'cancel';
    const STATUS_WORKING = 'work';
    const STATUS_COMPLETED = 'complete';
    const STATUS_FAILED = 'fail';

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
        $this->status;
        if ($status === 'new'){
            return ['cancel', 'work'];
        }
        if ($status === 'cancel' || $status === 'complete' || $status === 'fail'){
            return '';
        }
        if ($status === 'work'){
            return ['complete', 'fail'];
        }
    }

    public function getStatus($action){
        if ($action === 'new'){

        }
    }
    //Определять список из всех доступных действий и статусов;
    //Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия;
}
