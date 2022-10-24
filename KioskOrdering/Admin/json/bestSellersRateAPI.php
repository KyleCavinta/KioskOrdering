<?php

    function p($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    include '../includes/class-loader.php';
    
    $selectObj = new Select();
    $category = $_GET['cat'] ?? "";
    
    $fromFood = $selectObj->getFoodBestSeller($category);
    $fromPromo = $selectObj->getFoodBestSellerFromPromo($category);
    
    for($i = 0; $i < count($fromFood); $i++){
        for($j = 0; $j < count($fromPromo); $j++){
            if($fromFood[$i]['FoodID'] == $fromPromo[$j]['FoodID']){
                $fromFood[$i]['TotalSold'] = $fromFood[$i]['TotalSold'] + $fromPromo[$j]['TotalSold'];
                unset($fromPromo[$j]);
            }
        }
        $fromPromo = array_values($fromPromo);
    }
    
    for($i = 0; $i < count($fromFood); $i++){
        for($j = $i + 1; $j < count($fromFood); $j++){
            if($fromFood[$i]['TotalSold'] < $fromFood[$j]['TotalSold']){
                $tmp = $fromFood[$i];
                $fromFood[$i] = $fromFood[$j];
                $fromFood[$j] = $tmp;
            }
        }
    }
    
    echo json_encode($fromFood);