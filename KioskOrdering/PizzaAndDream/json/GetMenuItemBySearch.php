<?php

    include '../includes/class-loader.php';

    $selectObj = new Select();
    $searchedFoods = $selectObj->getFoodsBySearch($_GET['str']);
    $searchedPromos = $selectObj->getPromosBySearch($_GET['str']);
    
    $foodBestSell = $selectObj->getFoodBestSeller("");
    $foodPromoBestSell = $selectObj->getFoodBestSellerFromPromo("");
    
    foreach($foodBestSell as $foodKey => $food){
        foreach($foodPromoBestSell as $foodPromKey => $foodProm){
            if($food['FoodID'] == $foodProm['FoodID']){
                $foodBestSell[$foodKey]['TotalSold'] = $foodPromoBestSell[$foodPromKey]['TotalSold'] + $foodBestSell[$foodKey]['TotalSold'];
            }
        }
    }
    
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
    
    foreach($searchedFoods as $key => $food){
        if($food['FoodID'] == $chicken[0]['FoodID']){
            $searchedFoods[$key]['Status'] = 1;
        } else if($food['FoodID'] == $pasta[0]['FoodID']){
            $searchedFoods[$key]['Status'] = 1;
        } else if($food['FoodID'] == $pizza[0]['FoodID']){
            $searchedFoods[$key]['Status'] = 1;
        }
    }
    
    
    echo json_encode(array_merge($searchedFoods, $searchedPromos));