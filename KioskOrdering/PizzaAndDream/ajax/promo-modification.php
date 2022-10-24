<?php
    session_start();
    include '../includes/class-loader.php';
    $selectObj = new Select();
    
    function show($stuff){
        echo "<pre>";
        print_r($stuff);
        echo "</pre>";
    }
    
    $orders = json_decode(file_get_contents('../../Cart.json'), true)[$_SESSION['TABLE_NO']];
    $promoItems = $orders['PromoItems'];
    $promo = $selectObj->getPromoByPromoID($promoItems[$_POST['index']]['PromoID']);
    $cartFoodIncluded = $promoItems[$_POST['index']]['FoodIncluded'];
    $promoIncludes = $selectObj->getPromoIncludesByPromoID($promoItems[$_POST['index']]['PromoID']);
    $selectedOptions = [];
    
    for($i = 0; $i < count($promoIncludes); $i++){
        $foods = array_column($selectObj->getFoodsByCategoryAndMinPrice($promoIncludes[$i]['Category']), "FoodID");

        for($j = 0; $j < $promoIncludes[$i]['Quantity']; $j++){
            for($k = 0; $k < count($foods); $k++){
                if($cartFoodIncluded[$j] == $foods[$k]){
                    $selectedOptions[$i][$j][$k] = "selected";
                }
                else{
                    $selectedOptions[$i][$j][$k] = "";
                }
            }
            unset($cartFoodIncluded[$j]);
        }
        $cartFoodIncluded = array_values($cartFoodIncluded);
    }
?>

<link rel="stylesheet" href="../styles/promo-modification.css?v=<?php echo time()?>">

<div class="header">
    <h5 class="title">Edit Promo Items</h5>
</div>
<div class="body">
    <img src="../img/menu-items/<?=$promo['Image']?>">
    <h1><?=$promo['Name']?></h1>
    
    <?php for($i = 0; $i < count($promoIncludes); $i++): ?>
        <?php for($j = 0; $j < $promoIncludes[$i]['Quantity']; $j++): ?>
            <?php $food = $selectObj->getFoodsByCategoryAndMinPrice($promoIncludes[$i]['Category']) ?>
            
            <span>Choose your <?php echo ucfirst($promoIncludes[$i]['Category'])?></span>
            <select>
                <?php for($k = 0; $k < count($food); $k++): ?>
                    <option value="<?php echo $food[$k]['FoodID']?>" <?php echo ($selectedOptions[$i][$j][$k])?>><?php echo $food[$k]['Name']?></option>
                <?php endfor ?>
            </select>
            
        <?php endfor ?>
        <div class="mb-5"></div>
    <?php endfor ?>
    
    <div class="d-flex justify-content-end align-items-center">
        <sup class="me-3">Total</sup>
        <h1>₱<?php echo $promo['Price']?></h1>
    </div>
    
    <div class="text-end mt-2">
        <small style="color: #c9c9c9;"><?php echo ucwords($promoItems[$_POST['index']]['ServiceStatus'])?></small>
    </div>
</div>
<div class="footer">
    <button id="btnCancel">Cancel</button>
    <button id="btnRemove" style="background:#CA0B00;">Remove</button>
    <button id="btnEdit">Edit</button>
</div>

<input type="hidden" value="<?php echo $_POST['index']?>" id="itemIndex">
<script>$.getScript('../js/promo-modification.js')</script>