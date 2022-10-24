<?php
    include '../includes/class-loader.php';

    $selectObj = new Select();

    $menuItems = array();

    $foodItems = $selectObj->getFoodsByCategory($_GET['cat']);
    
    $foodBestSell = $selectObj->getFoodBestSeller($_GET['cat']);
    $foodPromoBestSell = $selectObj->getFoodBestSellerFromPromo($_GET['cat']);
    
    foreach($foodBestSell as $foodKey => $food){
        foreach($foodPromoBestSell as $foodPromKey => $foodProm){
            if($food['FoodID'] == $foodProm['FoodID']){
                $foodBestSell[$foodKey]['TotalSold'] = $foodPromoBestSell[$foodPromKey]['TotalSold'] + $foodBestSell[$foodKey]['TotalSold'];
            }
        }
    }
    
    if($_GET['cat'] == ""){
        for($i = 0; $i < count($foodBestSell); $i++){
            for($j = 0; $j < count($foodBestSell) - 1; $j++){
                if($foodBestSell[$j]['TotalSold'] < $foodBestSell[$j + 1]['TotalSold']){
                    $temp = $foodBestSell[$j];
                    $foodBestSell[$j] = $foodBestSell[$j + 1];
                    $foodBestSell[$j + 1] = $temp;
                }
            }
        }
        
        $chicken = [];
        $pasta = [];
        $pizza = [];
        foreach($foodBestSell as $food){
            if($food['Category'] == "Chicken"){
                array_push($chicken, $food);
            } else if($food['Category'] == "Pasta"){
                array_push($pasta, $food);
            } else if($food['Category'] == "Pizza"){
                array_push($pizza, $food);
            }
        }
        
        foreach($foodItems as $key => $food){
            if($food['FoodID'] == $chicken[0]['FoodID']){
                $foodItems[$key]['Status'] = 1;
            } else if($food['FoodID'] == $pasta[0]['FoodID']){
                $foodItems[$key]['Status'] = 1;
            } else if($food['FoodID'] == $pizza[0]['FoodID']){
                $foodItems[$key]['Status'] = 1;
            }
        }
    }
    else if($_GET['cat'] != "Drinks"){
        for($i = 0; $i < count($foodBestSell); $i++){
            for($j = 0; $j < count($foodBestSell) - 1; $j++){
                if($foodBestSell[$j]['TotalSold'] < $foodBestSell[$j + 1]['TotalSold']){
                    $temp = $foodBestSell[$j];
                    $foodBestSell[$j] = $foodBestSell[$j + 1];
                    $foodBestSell[$j + 1] = $temp;
                }
            }
        }
        
        foreach($foodItems as $key => $food){
            if($food['FoodID'] == $foodBestSell[0]['FoodID']){
                $foodItems[$key]['Status'] = 1;
            }
        }
    }
    
    if($_GET['cat'] == "Promo" || $_GET['cat'] == ""){
        $promoItems = $selectObj->getPromos();
    }
    else{
        $promoItems = [];
    }
    
    echo json_encode(array_merge($foodItems, $promoItems));