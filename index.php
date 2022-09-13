<?php
require 'vendor/autoload.php';
use TaskForce\models\Task;

$task = new Task(Task::STATUS_WORKING,1,2);