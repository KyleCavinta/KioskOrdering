<?php

session_start();

$orders = file_get_contents('../../Cart.json');
$orders = json_decode($orders, true);

unset($orders[$_SESSION['TABLE_NO']]['Payment']['PaymentMethod']);
unset($orders[$_SESSION['TABLE_NO']]['Payment']['AmountPaid']);
file_put_contents('../../Cart.json', json_encode($orders));