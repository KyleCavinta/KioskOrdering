<?php

session_start();

$orders = file_get_contents('../../Cart.json');
$orders = json_decode($orders, true);

$paymentMethod = $_POST['payment-method'];
$amountPaid = $_POST['amount-paid'];

$orders[$_SESSION['TABLE_NO']]["Payment"] = array(
    "PaymentMethod" => "GCash",
    "AmountPaid" => 0
);


file_put_contents('../../Cart.json', json_encode($orders));