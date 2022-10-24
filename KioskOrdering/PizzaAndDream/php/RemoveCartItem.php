<?php

session_start();
$index = $_POST['index'];
$category = $_POST['category'];
$orders = json_decode(file_get_contents('../../Cart.json'), true)[$_SESSION['TABLE_NO']];

if($category == "food"){
    $foodItem = $orders['FoodItems'][$index];
    if($foodItem['ServiceStatus'] == "pending" && $foodItem['ItemStatus'] == "new"){
        unset($orders['FoodItems'][$index]);
        $orders['FoodItems'] = array_values($orders['FoodItems']);
        echo true;
        
    }
    else{
        echo false;
    }
}
else{
    $promoItem = $orders['PromoItems'][$index];
    if($promoItem['ServiceStatus'] == "pending" && $promoItem['ItemStatus'] == "new"){
        unset($orders['PromoItems'][$index]);
        $orders['PromoItems'] = array_values($orders['PromoItems']);
        echo true;
        
    }
    else{
        echo false;
    }
}

$data = json_decode(file_get_contents('../../Cart.json'), true);
$data[$_SESSION['TABLE_NO']] = $orders;
file_put_contents('../../Cart.json', json_encode($data));