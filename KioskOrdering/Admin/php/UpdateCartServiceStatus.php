<?php

$orders = json_decode(file_get_contents('../../Cart.json'), true)[$_POST['table-no']];
$foodItems = $orders['FoodItems'];
$promoItems = $orders['PromoItems'];

for($i = 0; $i < count($foodItems); $i++){
    $foodItems[$i]['ServiceStatus'] = $_POST['status'];
    $foodItems[$i]['ItemStatus'] = ($_POST['status'] == "pending") ? "new" : "old";
}

for($i = 0; $i < count($promoItems); $i++){
    $promoItems[$i]['ServiceStatus'] = $_POST['status'];
    $promoItems[$i]['ItemStatus'] = ($_POST['status'] == "pending") ? "new" : "old";
}

$orders['FoodItems'] = $foodItems;
$orders['PromoItems'] = $promoItems;

$data = json_decode(file_get_contents('../../Cart.json'), true);
$data[$_POST['table-no']] = $orders;
file_put_contents('../../Cart.json', json_encode($data));