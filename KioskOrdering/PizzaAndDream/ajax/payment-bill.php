<?php
    function show($stuff){
        echo "<pre>";
        print_r($stuff);
        echo "</pre>";
    }

    date_default_timezone_set('Asia/Manila');
    
    include '../includes/class-loader.php';
    session_start();

    $selectObj = new Select();

    $tableNo = $_SESSION['TABLE_NO'];

    $items = file_get_contents('../../Cart.json');
    $items = json_decode($items, true);
    $foodItems = $items[$tableNo]['FoodItems'];
    $promoItems = $items[$tableNo]['PromoItems'];
    
    $uniquePromoItems = [];
    $uniquePromos = array_values(array_unique(array_column($promoItems, "PromoID")));
    for($i = 0; $i < count($uniquePromos); $i++){
        $promo = $selectObj->getPromoByPromoID($uniquePromos[$i]);
        $quantity = 0;
        $totalPrice = 0;
        for($j = 0; $j < count($promoItems); $j++){
            if($uniquePromos[$i] == $promoItems[$j]['PromoID']){
                $quantity++;
                $totalPrice = number_format($promo['Price'] + $totalPrice, 2, '.', '');
            }
        }
        
        array_push($uniquePromoItems, array(
            "PromoID" => $uniquePromos[$i],
            "Quantity" => $quantity,
            "TotalPrice" => $totalPrice
        ));
    }

    $totalPrice = 0;
?>

<i class="fas fa-times" id="btnCloseBill"></i>

<div class="top">
    <img src="../img/img_logo.png" width="130px">
    <div class="ms-3">
        <h1>Pizza and Dream</h1>
        <p><?php echo date('g:i a'); ?></p>
    </div>
</div>

<div class="mid">
    <?php for($i = 0; $i < count($foodItems); $i++): ?>
        <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID'])?>
        <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size'])['Description'] ?? ""?>
        <?php $totalPrice = $totalPrice + $foodItems[$i]['TotalPrice']?>
        <div class="item">
            <h3 class="item-name"><?php echo $foodItems[$i]['Quantity'] . "x " . $food['Name']?> (<?php echo $size . " " . $food['Category']?>)</h3>
            <h3 class="item-price">₱<?php echo $foodItems[$i]['TotalPrice']; ?></h3>
        </div>
    <?php endfor; ?>

    <?php for($i = 0; $i < count($uniquePromoItems); $i++): ?>
        <?php $promo = $selectObj->getPromoByPromoID($promoItems[$i]['PromoID'])?>
        <?php $totalPrice = $totalPrice + $uniquePromoItems[$i]['TotalPrice']?>
        <div class="item">
            <h3 class="item-name"><?php echo $uniquePromoItems[$i]['Quantity'] . "x " . $promo['Name']?> </h3>
            <h3 class="item-price">₱<?php echo $uniquePromoItems[$i]['TotalPrice']?></h3>
        </div>
    <?php endfor; ?>

    <div class="hr"></div>

    <div class="item tax">
        <?php $tax = $totalPrice * .12; ?>
        <h3 class="item-name">VAT 12%</h3>
        <h3 class="item-price">₱<?php echo number_format($tax, 2, '.', '')?></h3>
    </div>
    <div class="item total">
        <h2 class="item-name">Total</h2>
        <h2 class="item-price">₱<?php echo number_format($totalPrice, 2, '.', '') ?></h2>
    </div>
</div>