<?php

session_start();
include '../includes/class-loader.php';

$insertObj = new Insert();
$selectObj = new Select();
$updateObj = new Update();

$insertObj->setFeedback($selectObj->getIncrementedID('customer_feedback', 'FeedbackID'), $_SESSION['TABLE_NO'], $_POST['feedback']);
$updateObj->updateTableStatus($_SESSION['TABLE_NO'], "Available");