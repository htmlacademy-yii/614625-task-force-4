<?php
require __DIR__ . '/scr/models/Task.php';

$task = new Task(Task::STATUS_NEW,1);

var_dump($task);