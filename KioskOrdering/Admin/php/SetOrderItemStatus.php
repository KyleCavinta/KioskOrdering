<?php

include '../includes/class-loader.php';
$selectObj = new Select();

$dataOrders = json_decode(file_get_contents('../../Cart.json'), true);

$tableOrders = $dataOrders[$_POST['table-no']];
$foods = $tableOrders['food'];
$promos = $tableOrders['promo'];

for($i = 0; $i < count($foods); $i++){
    if($foods[$i]['Confirmation'] == "confirmed"){
        $foods[$i]['Status'] = $_POST['status'];
        $foods[$i]['DataStatus'] = "old";
    }
}

for($i = 0; $i < count($promos); $i++){
    if($promos[$i]['Confirmation'] == "confirmed"){
        $promos[$i]['Status'] = $_POST['status'];
        $promos[$i]['DataStatus'] = "old";
    }
}

$dataOrders[$_POST['table-no']]['food'] = $foods;
$dataOrders[$_POST['table-no']]['promo'] = $promos;

if(file_put_contents('../../Cart.json', json_encode($dataOrders))){
    echo "edited";
}