<?php

include '../includes/class-loader.php';

$selectObj = new Select();

$foods = $selectObj->getPaymentTransactionsFoodOrders("", "");
$promo = $selectObj->getPaymentTransactionsPromoOrders("", "");

for($i = 0; $i < count($promo); $i++){
    for($j = $i + 1; $j < count($promo); $j++){
        if($promo[$i]['TransactionID'] === $promo[$j]['TransactionID']){
            $promo[$i]['TotalPrice'] = $promo[$i]['TotalPrice'] + $promo[$j]['TotalPrice'];
            unset($promo[$j]);
            $promo = array_values($promo);
        }
    }
}

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

$months = [
    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
];
$monthlySales = [];

foreach($months as $month){
    $totalPrice = 0;
    foreach($foods as $food){
        if($month === date("F", strtotime($food['DatePaid'])) && date("Y") === date("Y", strtotime($food['DatePaid']))){
            $totalPrice += $food['TotalPrice'];
        }
    }
    array_push($monthlySales, $totalPrice);
}

echo json_encode([$months, $monthlySales]);