<?php
    
    date_default_timezone_set('Asia/Manila');
    include '../includes/class-loader.php';
    
    $selectObj = new Select();
    
    $table = "";
    $payMeth = "";
    $todaysTotalSales = 0;
    
    $foodTransactions = $selectObj->getPaymentTransactionsFoodOrders($table, $payMeth);
    $promoTransactions = $selectObj->getPaymentTransactionsPromoOrders($table, $payMeth);
    
    $data = array();
    
    for($i = 0; $i < count($foodTransactions); $i++){
        $foodTransID = $foodTransactions[$i]['TransactionID'];
        
        for($j = 0; $j < count($promoTransactions); $j++){
            if($foodTransID == $promoTransactions[$j]['TransactionID']){
                array_push($data, $promoTransactions[$j]);
                $data[count($data) - 1]['TotalPrice'] = $promoTransactions[$j]['TotalPrice'] + $foodTransactions[$i]['TotalPrice'];
                unset($promoTransactions[$j]);
            }
        }
        $promoTransactions = array_values($promoTransactions);
    }
    
    for($i = 0; $i < count($foodTransactions); $i++){
        if(array_search($foodTransactions[$i]['TransactionID'], array_column($data, "TransactionID")) === false){
            array_push($data, $foodTransactions[$i]);
        }
    }
    
    for($i = 0; $i < count($promoTransactions); $i++){
        array_push($data, $promoTransactions[$i]);
    }
    
    for($i = 0; $i < count($data); $i++){
        if(date("Y-m-d", strtotime($data[$i]['DatePaid'])) == date("Y-m-d", strtotime("-1 day"))){
            $todaysTotalSales = $todaysTotalSales + $data[$i]['TotalPrice'];
        }
    }
    
    echo number_format($todaysTotalSales, 0, ".", ",");