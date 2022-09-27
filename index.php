<?php
require 'vendor/autoload.php';
use TaskForce\models\Task;
use TaskForce\importers\DataImporter;

$task = new Task(Task::STATUS_COMPLETED, 1, 2);
$data = new DataImporter("/data/categories.csv");

print_r('<pre>');
var_dump($data);
print_r('</pre>');
// $data->setFlags(DataImporter::READ_CSV);
// foreach ($data as $row) {
//     print_r('<pre>');
//     print_r($row);
//     print_r('</pre>');
//     // list($animal, $class, $legs) = $row;
//     // printf("A %s is a %s with %d legs\n", $animal, $class, $legs);
// }
