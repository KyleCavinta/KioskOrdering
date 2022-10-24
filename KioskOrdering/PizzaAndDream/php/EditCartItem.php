<?php

session_start();
$category = $_POST['category'];
$index = $_POST['index'];
$orders = json_decode(file_get_contents('../../Cart.json'), true)[$_SESSION['TABLE_NO']];

if($category == "food"){
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $totalPrice = number_format($_POST['totalPrice'], 2, '.', '');
    $foodItem = $orders['FoodItems'][$index];
    
    if($foodItem['ServiceStatus'] == "pending" && $foodItem['ItemStatus'] == "new"){
        $existingIndex = false;
        for($i = 0; $i < count($orders['FoodItems']); $i++){
            if($orders['FoodItems'][$i]['FoodID'] == $foodItem['FoodID'] && $orders['FoodItems'][$i]['Size'] == $size){
                if($orders['FoodItems'][$i]['ServiceStatus'] == "pending" && $orders['FoodItems'][$i]['ItemStatus'] == "new"){
                    $existingIndex = $i;
                    break;
                }
            }
        }
        
        if($existingIndex == $index){
            $foodItem['Quantity'] = $quantity;
            $foodItem['Size'] = $size;
            $foodItem['TotalPrice'] = $totalPrice;
            
            $orders['FoodItems'][$index] = $foodItem;
            echo true;
        }
        else{
            $foodItem = $orders['FoodItems'][$existingIndex];
            
            $foodItem['Quantity'] += $quantity;
            $foodItem['Size'] = $size;
            $foodItem['TotalPrice'] = number_format($totalPrice + $foodItem['TotalPrice'], 2, '.', '');
            
            unset($orders['FoodItems'][$index]);
            $orders['FoodItems'][$existingIndex] = $foodItem;
            $orders['FoodItems'] = array_values($orders['FoodItems']);
            
            echo true;
        }
    }
    else{
        echo false;
    }
}
else{
    $promoItem = $orders['PromoItems'][$index];
    if($promoItem['ServiceStatus'] == "pending" && $promoItem['ItemStatus'] == "new"){
        $promoItem['FoodIncluded'] = $_POST['foodIncluded'];
        
        $orders['PromoItems'][$index] = $promoItem;
        echo true;
    }
    else{
        echo false;
    }
}

$data = json_decode(file_get_contents('../../Cart.json'), true);
$data[$_SESSION['TABLE_NO']] = $orders;
file_put_contents('../../Cart.json', json_encode($data));