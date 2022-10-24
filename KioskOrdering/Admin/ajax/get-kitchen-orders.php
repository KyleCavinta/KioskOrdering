<?php
    include '../includes/class-loader.php';
    $selectObj = new Select();
    
    function isNew($serviceStatus, $itemStatus){
        return $serviceStatus == "pending" && $itemStatus == "new";
    }
    
    function isPreparing($serviceStatus, $itemStatus){
        if(($serviceStatus == "preparing" || $serviceStatus == "serving" || $serviceStatus == "enjoy") && $itemStatus == "old"){
            return true;
        }
        else{
            return false;
        }
    }
    
    function priorityStatus($statuses){
        if(array_search("pending", $statuses) !== false){
            return "pending";
        }elseif(array_search("preparing", $statuses) !== false){
            return "preparing";
        }elseif(array_search("serving", $statuses) !== false){
            return "serving";
        }elseif(array_search("enjoy", $statuses) !== false){
            return "enjoy";
        }
    }

    $orders = json_decode(file_get_contents('../../Cart.json'), true)[$_POST['table-no']];
    $foodItems = $orders['FoodItems'];
    $promoItems = $orders['PromoItems'];
    
    $statuses = array_merge(array_column($foodItems, "ServiceStatus"), array_column($promoItems, "ServiceStatus"));
?>

<?php if(isset($foodItems[0]['ServiceStatus'])): ?>
    <?php for($i = 0; $i < count($foodItems); $i++): ?>
        <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID'])?>
        <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size'])?>
        
        <?php if($orders['PageStatus'] == "orders"): ?>
            <tr>
                <td><?php echo isNew($foodItems[$i]['ServiceStatus'], $foodItems[$i]['ItemStatus']) ? "<div class='new'></div>" : ""?></td>
                <td><?php echo $food['Name'] . " (" . $food['Category'] . ")"?></td>
                <td><?php echo (isset($size['Size'])) ? $size['Size'] . " " . $size['Description'] : ""?></td>
                <td><?php echo $foodItems[$i]['Quantity']?>x</td>
            </tr>
        <?php elseif(isPreparing($foodItems[$i]['ServiceStatus'], $foodItems[$i]['ItemStatus'])): ?>
            <tr>
                <td><?php echo isNew($foodItems[$i]['ServiceStatus'], $foodItems[$i]['ItemStatus']) ? "<div class='new'></div>" : ""?></td>
                <td><?php echo $food['Name'] . " (" . $food['Category'] . ")"?></td>
                <td><?php echo (isset($size['Size'])) ? $size['Size'] . " " . $size['Description'] : ""?></td>
                <td><?php echo $foodItems[$i]['Quantity']?>x</td>
            </tr>
        <?php endif ?>
    <?php endfor ?>
<?php endif ?>

<?php if(isset($promoItems[0]['ServiceStatus'])): ?>
    <?php for($i = 0; $i < count($promoItems); $i++): ?>
        <?php $promo = $selectObj->getPromoByPromoID($promoItems[$i]['PromoID']) ?>
        
        <?php if($orders['PageStatus'] == "orders"): ?>
            <tr>
                <td><?php echo isNew($promoItems[$i]['ServiceStatus'], $promoItems[$i]['ItemStatus']) ? "<div class='new'></div>" : ""?></td>
                <td colspan="3">
                    <?php echo $promo['Name'] ?>
                    <ul>
                        <?php foreach($promoItems[$i]['FoodIncluded'] as $foodIncludes): ?>
                            <?php $food = $selectObj->getFoodByFoodID($foodIncludes)?>
                            <li><?php echo $food['Name'] . " (" . $food['Category'] . ")"?></li>
                        <?php endforeach ?>
                    </ul>
                </td>
            </tr>
        <?php elseif(isPreparing($promoItems[$i]['ServiceStatus'], $promoItems[$i]['ItemStatus'])): ?>
            <tr>
                <td><?php echo isNew($promoItems[$i]['ServiceStatus'], $promoItems[$i]['ItemStatus']) ? "<div class='new'></div>" : ""?></td>
                <td colspan="3">
                    <?php echo $promo['Name'] ?>
                    <ul>
                        <?php foreach($promoItems[$i]['FoodIncluded'] as $foodIncludes): ?>
                            <?php $food = $selectObj->getFoodByFoodID($foodIncludes)?>
                            <li><?php echo $food['Name'] . " (" . $food['Category'] . ")"?></li>
                        <?php endforeach ?>
                    </ul>
                </td>
            </tr>
        <?php endif ?>
    <?php endfor ?>
<?php endif ?>

<input type="hidden" value="<?php echo count($promoItems) + count($foodItems)?>" id="ordersCount">
<input type="hidden" value="<?php echo priorityStatus($statuses)?>" id="status">
<input type="hidden" value="<?php echo $orders['PageStatus']?>" id="pageStatus">