<?php

class Task
{
    //статус: Новое, отменено, в работе, выполнено, провалено
    const STATUS_NEW = 'new';
    const STATUS_CANCEL = 'cancel';
    const STATUS_WORK = 'work';
    const STATUS_COMPLETE = 'complete';
    const STATUS_FAIL = 'fail';

    public $status;
    public $idExecutor;
    public $idCustomer;

    //Определять список из всех доступных действий и статусов;
    //Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия;
    //Определять список доступных действий в текущем статусе;
    //Хранить текущий статус задания;
    //Хранить ID исполнителя и ID заказчика.
}