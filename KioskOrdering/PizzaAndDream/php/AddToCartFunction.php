<?php

session_start();
$tableOrders = json_decode(file_get_contents('../../Cart.json'), true)[$_SESSION['TABLE_NO']];

if($_POST['category'] == "Food"){
    $orderedFoodItems = $tableOrders['FoodItems'];
    $index = false;
    for($i = 0; $i < count($orderedFoodItems); $i++){
        if($orderedFoodItems[$i]['FoodID'] == $_POST['FoodID'] && $orderedFoodItems[$i]['Size'] == $_POST['Size']){
            if($orderedFoodItems[$i]['ServiceStatus'] == "pending" && $orderedFoodItems[$i]['ItemStatus'] == "new"){
                $index = $i;
                break;
            }
        }
    }
    if($index === false){
        //Add Food Item
        $foodItem = array(
            'FoodID' => $_POST['FoodID'],
            'Quantity' => $_POST['Quantity'],
            'Size' => $_POST['Size'],
            'TotalPrice' => number_format($_POST['TotalPrice'], 2, '.', ''),
            'ServiceStatus' => "pending",
            'ItemStatus' => "new",
        );
        array_push($tableOrders['FoodItems'], $foodItem);
    }
    else{
        $orderedFoodItems[$index]['Quantity'] += $_POST['Quantity'];
        $orderedFoodItems[$index]['TotalPrice'] = number_format($orderedFoodItems[$index]['TotalPrice'] + $_POST['TotalPrice'], 2, '.', '');
        
        $tableOrders['FoodItems'] = $orderedFoodItems;
    }
}
else{
    $promoItem = array(
        'PromoID' => $_POST['PromoID'],
        'FoodIncluded' => explode(',', $_POST['FoodIncluded']),
        'ServiceStatus' => "pending",
        'ItemStatus' => "new",
    );
    array_push($tableOrders['PromoItems'], $promoItem);
}

$data = json_decode(file_get_contents('../../Cart.json'), true);
$data[$_SESSION['TABLE_NO']] = $tableOrders;
file_put_contents('../../Cart.json', json_encode($data));