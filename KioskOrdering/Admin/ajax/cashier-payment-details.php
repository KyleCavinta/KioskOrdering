<?php

    include '../includes/class-loader.php';
    $selectObj = new Select();
    
    $tableData = json_decode(file_get_contents('../../Cart.json'), true)[$_POST['table-no']];
    $foodItems = $tableData['FoodItems'];
    $promoItems = $tableData['PromoItems'];
    $payment = $tableData['Payment'];
    
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

<?php if(isset($payment['PaymentMethod'])): ?>
    <?php for($i = 0; $i < count($foodItems); $i++): ?>
        <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID'])?>
        <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size'])?>
        <?php $totalPrice += $foodItems[$i]['TotalPrice']?>
        <tr>
            <td><?php echo $size['Description'] ?? ""?> <?php echo $food['Name'] . " " . $food['Category']?></td>
            <td><?php echo $foodItems[$i]['Quantity']?></td>
            <td>₱ <?php echo $foodItems[$i]['TotalPrice']?></td>
        </tr>
    <?php endfor ?>
    <?php for($i = 0; $i < count($uniquePromoItems); $i++): ?>
        <?php $promo = $selectObj->getPromoByPromoID($uniquePromoItems[$i]['PromoID'])?>
        <?php $totalPrice += $uniquePromoItems[$i]['TotalPrice']?>
        <tr>
            <td><?php echo $promo['Name']?></td>
            <td><?php echo $uniquePromoItems[$i]['Quantity']?></td>
            <td>₱ <?php echo $uniquePromoItems[$i]['TotalPrice']?></td>
        </tr>
    <?php endfor ?>
<?php endif ?>

<?php if(isset($payment['PaymentMethod'])): ?>
    <input type="hidden" value="<?php echo number_format($totalPrice - ($totalPrice * .12), 2, '.', '')?>" id="subTotal">
    <input type="hidden" value="<?php echo number_format($totalPrice * .12, 2, '.', '')?>" id="tax">
    <input type="hidden" value="<?php echo number_format($totalPrice, 2, '.', '')?>" id="totalPrice">
    <input type="hidden" value="<?php echo number_format(($payment['PaymentMethod'] == "GCash") ? 0 : $payment['AmountPaid'], 2, '.', '')?>" id="amountPaid">
    <input type="hidden" value="<?php echo $payment['PaymentMethod']?>" id="paymentMethod">
<?php else: ?>
    <input type="hidden" value="<?php echo 0?>" id="subTotal">
    <input type="hidden" value="<?php echo 0?>" id="tax">
    <input type="hidden" value="<?php echo 0?>" id="totalPrice">
    <input type="hidden" value="<?php echo 0?>" id="amountPaid">
    <input type="hidden" value="<?php echo ""?>" id="paymentMethod">
<?php endif ?>