<?php
    date_default_timezone_set('Asia/Manila');

    function computeItemBySize($origPrice, $size, $category){
        $totalPrice = 0;
        if($category == "Pizza"){
            switch($size){
                case "Double":{
                    $totalPrice = $origPrice;
                }break;
                case "Medium":{
                    $totalPrice = $origPrice + 210.00;
                }break;
                case "Large":{
                    $totalPrice = $origPrice + (210.00 * 2);
                }break;
                case "XLarge":{
                    $totalPrice = $origPrice + (210.00 * 3);
                }break;
            }
        }
        else if($category == "Chicken"){
            if($size == "Large"){
                $totalPrice = $origPrice + 230.00;
            }
            else{
                $totalPrice = $origPrice;
            }
        }
        else if($category == "Pasta"){
            if($size == "Large"){
                $totalPrice = $origPrice + 170.00;
            }
            else{
                $totalPrice = $origPrice;
            }
        }
        else{
            $totalPrice = $origPrice;
        }
        
        return number_format($totalPrice, 2, '.', '');
    }

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

<div class="top">
    <h5 class="text-center">Pizza and Dream</h5>
    <p class="text-center px-5">Hampton East Arcade, C. Raymundo Ave, Pasig, 1607 Metro Manila</p>
    <p class="text-center">Phone: (02) 8789 9999</p>
</div>

<div class="d-flex mt-3">
    <p class="w-100">Transaction# <?php echo $selectObj->getIncrementedID('payment_transaction', 'TransactionID');?></p>
    <p class="text-end w-100">Date: <?php echo date("Y-m-d H:i:s")?></p>
</div>

<div class="divider mt-1"></div>
<table>
    <thead>
        <tr>
            <th>ITEM</th>
            <th>QTY</th>
            <th>UNIT PRICE</th>
            <th>AMOUNT</th>
        </tr>
    </thead>
    <tbody>
        <?php for($i = 0; $i < count($foodItems); $i++): ?>
            <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID'])?>
            <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size'])?>
            <?php $totalPrice += $foodItems[$i]['TotalPrice']?>
            <tr>
                <td><?php echo $size['Description'] ?? ""?> <?php echo $food['Name'] . " " . $food['Category']?></td>
                <td><?php echo $foodItems[$i]['Quantity']?></td>
                <td>₱ <?php echo computeItemBySize($food['Price'], ($size['Description'] ?? ""), $food['Category']);?></td>
                <td>₱ <?php echo $foodItems[$i]['TotalPrice']?></td>
            </tr>
        <?php endfor ?>
        
        <?php for($i = 0; $i < count($uniquePromoItems); $i++): ?>
            <?php $promo = $selectObj->getPromoByPromoID($uniquePromoItems[$i]['PromoID'])?>
            <?php $totalPrice += $uniquePromoItems[$i]['TotalPrice']?>
            <tr>
                <td><?php echo $promo['Name']?></td>
                <td><?php echo $uniquePromoItems[$i]['Quantity']?></td>
                <td>₱ <?php echo $promo['Price']?></td>
                <td>₱ <?php echo $uniquePromoItems[$i]['TotalPrice']?></td>
            </tr>
        <?php endfor ?>
        
        <!-- Payment Details -->
        <tr style="border-top: 2px dashed #000000">
            <td></td>
            <td></td>
            <td style="font-weight: 700;">Subtotal:</td>
            <td style="font-weight: 700;">₱ <?php echo number_format($totalPrice - ($totalPrice * .12), 2, '.', '')?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: 700;">VAT(12%):</td>
            <td style="font-weight: 700;">₱ <?php echo number_format($totalPrice * .12, 2, '.', '')?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: 700;">Total:</td>
            <td style="font-weight: 700;">₱ <?php echo number_format($totalPrice, 2, '.', '')?></td>
        </tr>
        <tr style="border-top: 2px dashed #000000">
            <td colspan="4" style="font-weight: 700;">Payment Details</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: 700;" class="text-start px-2">Payment Method:</td>
            <td colspan="2" style="font-weight: 700;" class="text-end px-2"><?php echo $payment['PaymentMethod']?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: 700;" class="text-start px-2">Amount Paid:</td>
            <td colspan="2" style="font-weight: 700;" class="text-end px-2">₱ <?php echo number_format(($payment['PaymentMethod'] == "GCash") ? ($totalPrice) : $payment['AmountPaid'], 2, '.', '')?></td>
        </tr>
    </tbody>
</table>