<?php
require 'vendor/autoload.php';
use TaskForce\models\Task;

$task = new Task(Task::STATUS_NEW,1,2);