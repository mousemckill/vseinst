<?php
require_once './db.php';

$startDate = new DateTime('2017-06-01');
$nowDate = new DateTime();
$interval = DateInterval::createFromDateString('1 day');
$days = new DatePeriod($startDate, $interval, $nowDate);

$db = new DB();
$couriers = $db->getTable('couriers');
$regions = $db->getTable('regions');

foreach ($days as $day) {
    $count_orders = rand(0, count($regions));
    // get free couriers limit orders
}