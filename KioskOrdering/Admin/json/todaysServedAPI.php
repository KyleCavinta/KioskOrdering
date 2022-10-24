<?php

include '../includes/class-loader.php';

$selectObj = new Select();
$ordersMade = $selectObj->getTodaysServed();

echo $ordersMade['COUNT(*)'];