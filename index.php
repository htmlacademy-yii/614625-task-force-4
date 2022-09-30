<?php
require 'vendor/autoload.php';
use TaskForce\models\Task;
use TaskForce\importers\DataImporter;

$task = new Task(Task::STATUS_COMPLETED, 1, 2);

// $categories = new DataImporter();
// $categories->getFileObject("\data\categories.csv");

$cities = new DataImporter();
$cities->getFileObject("\data\cities.csv");
