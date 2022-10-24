<?php
    include '../includes/class-loader.php';
    $selectObj = new Select();

    $orders = file_get_contents('../../Cart.json');
    $orders = json_decode($orders, true);

    $tableOrders = $orders[$_POST['table-no']];
    $foodItems = $tableOrders['FoodItems'];
    $promos = $tableOrders['PromoItems'];
    $payment = $tableOrders['Payment'];

    $uniquePromos = array_values(array_unique(array_column($promos, "PromoID")));
    $promoData = [];
    for($i = 0; $i < count($uniquePromos); $i++){
        $count = 0;
        for($j = 0; $j < count($promos); $j++){
            if($uniquePromos[$i] == $promos[$j]['PromoID']){
                $count++;
            }
        }
        $promoData[$i]['PromoID'] = $uniquePromos[$i];
        $promoData[$i]['Quantity'] = $count;
    }

    $subTotal = 0;
?>

<?php if(isset($payment['PaymentMethod'])): ?>
    <?php for($i = 0; $i < count($foodItems); $i++): ?>
        <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID'])?>
        <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size'])['Description'] ?? ""?>
                
        <?php $subTotal += $foodItems[$i]['TotalPrice']?>
        <div class="item">
            <div class="order-name">
                <?php echo $food['Name'] . " (" . $size . " " . $food['Category'] . ")"?>
            </div>
            <div class="mx-3">
                <?php echo $foodItems[$i]['Quantity']?>x
            </div>
            <div class="order-price">
                ₱ <?php echo $foodItems[$i]['TotalPrice']?>
            </div>
        </div>
    <?php endfor ?>

    <?php for($i = 0; $i < count($promoData); $i++): ?>
        <?php $promo = $selectObj->getPromoByPromoID($promoData[$i]['PromoID'])?>
        <?php $subTotal += ($promo['Price'] * $promoData[$i]['Quantity'])?>
        <div class="item">
            <div class="order-name">
                <?php echo $promo['Name'] . " (Promo)"?>
            </div>
            <div class="mx-3">
                <?php echo $promoData[$i]['Quantity']?>x
            </div>
            <div class="order-price">
                ₱ <?php echo number_format($promo['Price'] * $promoData[$i]['Quantity'], 2, '.', '')?>
            </div>
        </div>
    <?php endfor ?>
<?php endif ?>

<input type="hidden" value="<?php echo $subTotal?>" id="subTotal">
<input type="hidden" value="<?php echo number_format($subTotal * .12, 2, '.', '')?>" id="tax">
<input type="hidden" value="<?php echo number_format(($subTotal * .12) + $subTotal, 2, '.', '')?>" id="total">

<?php if(isset($payment['PaymentMethod'])): ?>
    <input type="hidden" value="<?php echo ($payment['PaymentMethod'] == "cash") ? "₱" . $payment['AmountPaid'] : "GCash" ?>" id="payment">
<?php else: ?>
    <input type="hidden" value="0" id="payment">
<?php endif; ?>