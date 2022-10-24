<?php

include '../includes/class-loader.php';

$selectObj = new Select();

$foods = $selectObj->getPaymentTransactionsFoodOrders("", "");
$promo = $selectObj->getPaymentTransactionsPromoOrders("", "");

$intersectedTransactions = array_intersect(
    array_column($foods, "TransactionID"),
    array_column($promo, "TransactionID")
);

foreach($intersectedTransactions as $transaction){
    $foodIdx = array_search($transaction, array_column($foods, "TransactionID"));
    $promoIdx = array_search($transaction, array_column($promo, "TransactionID"));
    
    if($foods[$foodIdx]['TransactionID'] === $promo[$promoIdx]['TransactionID']){
        $foods[$foodIdx]['TotalPrice'] = $promo[$promoIdx]['TotalPrice'] + $foods[$foodIdx]['TotalPrice'];
        unset($promo[$promoIdx]);
        $promo = array_values($promo);
    }
}

foreach($promo as $pr){
    array_push($foods, $pr);
}

sort($foods);

$totalPrice = 0;
foreach($foods as $food){
    $totalPrice += $food['TotalPrice'];
}

echo number_format($totalPrice / count($foods), 2, ".", ",");