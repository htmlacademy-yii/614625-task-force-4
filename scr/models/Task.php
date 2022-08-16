<?php

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCEL = 'cancel';
    const STATUS_WORK = 'work';
    const STATUS_COMPLETE = 'complete';
    const STATUS_FAIL = 'fail';

    public $status;
    public $idExecutor;
    public $idCustomer;

    function getAction($status){
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

    function getStatus($action){
        if ($action === 'new'){

        }
    }
    //Определять список из всех доступных действий и статусов;
    //Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия;
}
