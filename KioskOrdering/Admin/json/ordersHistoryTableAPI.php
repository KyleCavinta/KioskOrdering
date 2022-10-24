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

for($i = 0; $i < count($foods); $i++){
    $foods[$i]['TotalPrice'] = number_format($foods[$i]['TotalPrice'], 2, '.', ',');
}

sort($foods);
$data = [];

foreach($foods as $key => $value){
    if(str_contains($foods[$key]['PaymentMethod'], $_GET['payMeth'])){
        if(str_contains($foods[$key]['TableNo'], $_GET['tbl'])){
            $foods[$key]['PaymentMethod'] = ucfirst($foods[$key]['PaymentMethod']);
            array_push($data, $foods[$key]);
        }
    }
}

function sortByDate($year, $month, $day, $array){
    $output = [];
    $date = "";
    
    if($year == ""){
        $date = "";
    }
    else if($month == ""){
        $date = $year . "-";
    }
    else if($day == ""){
        $date = $year . "-" . $month . "-";
    }
    else{
        $date = $year . "-" . $month . "-" . $day;
    }
    
    foreach($array as $key => $val){
        if(str_contains(date('Y-m-d', strtotime($array[$key]['DatePaid'])), $date)){
            array_push($output, $array[$key]);
        }
    }
    
    return $output;
}

$arr = sortByDate($_GET['year'], $_GET['month'], $_GET['day'], $data);
echo json_encode($arr);