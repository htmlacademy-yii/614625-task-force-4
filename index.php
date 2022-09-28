<?php
require 'vendor/autoload.php';
use TaskForce\models\Task;
use TaskForce\importers\DataImporter;

$task = new Task(Task::STATUS_COMPLETED, 1, 2);

$data = new DataImporter();
$data->getFileObject("\data\categories.csv");
//$echo = $data->getFileObject("/data/categories.csv");

//$file->setFlags(SplFileObject::READ_CSV);

//var_dump($echo);

