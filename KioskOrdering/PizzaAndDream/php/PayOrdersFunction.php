<?php

function getSameItems($array, $column, $value){
    $same = [];
    
    for($i = 0; $i < count($array); $i++){
        if($array[$i][$column] == $value){
            array_push($same, $array[$i]);
        }
    }
    return $same;
}

session_start();
include '../includes/class-loader.php';
$selectObj = new Select();

$tableOrders = json_decode(file_get_contents('../../Cart.json'), true)[$_SESSION['TABLE_NO']];
$foodItems = $tableOrders['FoodItems'];
$promoItems = $tableOrders['PromoItems'];

$uniqueFoodID = array_values(array_unique(array_column($foodItems, "FoodID")));
$newFoodItems = [];
for($i = 0; $i < count($uniqueFoodID); $i++){
    $sameFoodID = getSameItems($foodItems, "FoodID", $uniqueFoodID[$i]);
    $sameSize = array_values(array_unique(array_column($sameFoodID, "Size")));
    
    for($j = 0; $j < count($sameSize); $j++){
        $placeholder['FoodID'] = $sameFoodID[$j]['FoodID'];
        $placeholder['Quantity'] = 0;
        $placeholder['Size'] = $sameSize[$j];
        $placeholder["TotalPrice"] = 0;
        
        for($k = 0; $k < count($sameFoodID); $k++){
            if($sameSize[$j] == $sameFoodID[$k]['Size']){
                $placeholder['Quantity'] += $sameFoodID[$k]['Quantity'];
                $placeholder['TotalPrice'] = number_format($sameFoodID[$k]['TotalPrice'] + $placeholder['TotalPrice'], 2, '.', '');
            }
        }
        array_push($newFoodItems, $placeholder);
    }
}

for($i = 0; $i < count($promoItems); $i++){
    unset($promoItems[$i]['ServiceStatus']);
    unset($promoItems[$i]['ItemStatus']);
}

$tableOrders = json_decode(file_get_contents('../../Cart.json'), true);
$tableOrders[$_SESSION['TABLE_NO']]['FoodItems'] = $newFoodItems;
$tableOrders[$_SESSION['TABLE_NO']]['PromoItems'] = $promoItems;
file_put_contents('../../Cart.json', json_encode($tableOrders));