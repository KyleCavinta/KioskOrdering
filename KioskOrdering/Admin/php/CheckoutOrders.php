<?php

include '../includes/class-loader.php';
$insertObj = new Insert();
$selectObj = new Select();

$tableNo = $_POST['table-no'];

$orders = file_get_contents('../../Cart.json');
$orders = json_decode($orders, true);
$tableOrders = $orders[$tableNo];

$payment = $tableOrders['Payment'];
$promoItems = $tableOrders['PromoItems'];
$foodItems = $tableOrders['FoodItems'];

$transactionID = $selectObj->getIncrementedID('payment_transaction', 'TransactionID');
if($payment['PaymentMethod'] == "GCash"){
    $insertObj->setPaymentTransaction($transactionID, $tableNo, $payment['PaymentMethod'], $_POST['gcash-paid']);
}
else{
    $insertObj->setPaymentTransaction($transactionID, $tableNo, $payment['PaymentMethod'], $payment['AmountPaid']);
}

for($i = 0; $i < count($promoItems); $i++){
    $orderID = $selectObj->getIncrementedID('promo_orders', 'OrderID');
    $promoID = $promoItems[$i]['PromoID'];
    $totalPrice = $selectObj->getPromoByPromoID($promoID)['Price'];
    $insertObj->setPromoOrders($orderID, $transactionID, $tableNo, $promoID, $totalPrice);

    $foodIncluded = $promoItems[$i]['FoodIncluded'];
    for($j = 0; $j < count($foodIncluded); $j++){
        $includeID = $selectObj->getIncrementedID('promo_orders_included', 'IncludeID');
        $foodID = $foodIncluded[$j];
        $insertObj->setPromoOrdersIncluded($includeID, $orderID, $foodID);
    }
}

for($i = 0; $i < count($foodItems); $i++){
    $orderID = $selectObj->getIncrementedID('food_orders', 'OrderID');
    $foodID = $foodItems[$i]['FoodID'];
    $sizeID = ($foodItems[$i]['Size'] == "") ? NULL : $foodItems[$i]['Size'];
    $quantity = $foodItems[$i]['Quantity'];
    $totalPrice = $foodItems[$i]['TotalPrice'];
    $insertObj->setFoodOrders($orderID, $transactionID, $tableNo, $foodID, $sizeID, $quantity, $totalPrice);
}


$orders[$tableNo] = array(
    "FoodItems" => [],
    "PromoItems" => [],
    "Payment" => [],
    "PageStatus" => ""
);

file_put_contents('../../Cart.json', json_encode($orders));