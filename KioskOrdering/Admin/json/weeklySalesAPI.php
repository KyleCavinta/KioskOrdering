<?php

include '../includes/class-loader.php';

date_default_timezone_set('Asia/Manila');

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

sort($foods);

$datesThisWeek = array(
    "Sunday" => date("Y-m-d", strtotime('sun this week')),
    "Monday" => date("Y-m-d", strtotime('mon this week')),
    "Tuesday" => date("Y-m-d", strtotime('tue this week')),
    "Wednesday" => date("Y-m-d", strtotime('wed this week')),
    "Thursday" => date("Y-m-d", strtotime('thu this week')),
    "Friday" => date("Y-m-d", strtotime('fri this week')),
    "Saturday" => date("Y-m-d", strtotime('sat this week')),
);

$weeklySales = [];

foreach($datesThisWeek as $key => $date){
    $totalPrice = 0;
    
    foreach($foods as $food){
        if($date === date("Y-m-d", strtotime($food['DatePaid']))){
            $totalPrice += $food['TotalPrice'];
        }
    }
    
    $weeklySales[$key] = $totalPrice;
}

$days = array_keys($weeklySales);
$amount = array_values($weeklySales);
echo json_encode([$days, $amount]);