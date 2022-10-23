<?php
$statuses = ['new', 'canceled','working','completed','failed'];

return [
    'creation_time' => '2022-10-09 00:00:00',
    'title' => $faker->title,
    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    'category_id' => rand(1, 8),
    'location_id' => 1,
    'customer_id' => 1,
    'status' => $statuses[rand(0 , (count($statuses) - 1))],
    'budget' => rand(1000, 18750),
    'date_completion' => '2022-10-09 00:00:00'
];
