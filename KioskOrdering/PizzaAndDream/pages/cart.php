<?php
    include '../includes/header.php';
    setPageStatus("cart");

    $tableNo = $_SESSION['TABLE_NO'];

    $items = file_get_contents('../../Cart.json');
    $items = json_decode($items, true);
    $foodItems = $items[$tableNo]['FoodItems'];
    $promoItems = $items[$tableNo]['PromoItems'];

    $totalPrice = 0;
?>
<link rel="stylesheet" href="../styles/cart.css?v=<?php echo time()?>">

        <div class="top">
            <i class="fa fa-chevron-left"></i>
            <div class="d-flex align-items-center justify-content-center gap-3" style="flex-grow: 1;">
                <img src="../img/ic_cart.png"> 
                <h1 class="cart">Cart</h1>
            </div>
        </div>

    <div class="orders-container">

            <div class="food-container">
                <?php for($i = 0; $i < count($foodItems); $i++): ?>
                    <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID']); ?>
                    <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size'])?>
                    <?php $totalPrice += $foodItems[$i]['TotalPrice']?>
                    
                    <div class="item" data-category="food" data-index="<?php echo $i?>">
                        <img src="../img/menu-items/<?php echo $food['Image']?>" width="125px" height="125px" class="HWN-icon">
                        <h1 class="Meal"><?php echo $food['Name']?></h1>
                        <h1 class="type"><?php echo $food['Category']?></h1>
                        <h1 class="type">Size: <?php echo is_array($size) ? $size['Size'] . " " . $size['Description'] : ""?></h1>
                        <h1 class="type">Quantity: <?php echo $foodItems[$i]['Quantity']?></h1>
                        <h1 class="HWN-price">₱ <?php echo number_format($foodItems[$i]['TotalPrice'], 2, '.', ''); ?></h1>
                        <hr class="line-1">
                    </div>
                <?php endfor; ?>

                <?php for($i = 0; $i < count($promoItems); $i++): ?>
                    <?php $promo = $selectObj->getPromoByPromoID($promoItems[$i]['PromoID'])?>
                    <?php $totalPrice += $promo['Price']?>
                    
                    <div class="item" data-index="<?php echo $i ?>">
                        <img src="../img/menu-items/<?php echo $promo['Image']?>" width="120px" height="120px" class="HWN-icon">
                        <h1 class="Meal"><?php echo $promo['Name']?></h1>
                        
                        <?php for($j = 0; $j < count($promoItems[$i]['FoodIncluded']); $j++): ?>
                            <?php $food = $selectObj->getFoodByFoodID($promoItems[$i]['FoodIncluded'][$j])?>
                            <h1 class="flavor-type">F <?php echo $j + 1 . ": " . $food['Name']?></h1>
                        <?php endfor; ?>
                        
                        <h1 class="type mt-2">Promo</h1>    
                        <h1 class="promo-price">₱ <?php echo $promo['Price']?></h1>
                        <hr class="line-1">
                    </div>
                 <?php endfor; ?>
                 
            </div>
                    <hr class="line-2">

            <div class = "total-price">
                <h1 class="total">Total :</h1>
                <h1 class="price">₱ <?php echo number_format($totalPrice, 2, '.', '')?></h1>
            </div>
    </div>

        <div class="btn-M-Order">
            <button id="btnMakeOrder">Make Order</button>
        </div>
        
<div class="mod-background" id="modifyItem">
    <div class="mod-content">
    </div>
</div>

<div class="mod-background" id="feedback">
    <div class="mod-content">
        <div class="header">
            <h5 class="title"></h5>
        </div>
        <div class="body">
            <p></p>
        </div>
        <div class="footer">
        </div>
    </div>
</div>

<input type="hidden" value="<?php echo $_SESSION['TABLE_NO']?>" id="tableNo">
<script src="../js/cart.js?v=<?php echo time();?>"></script>
<?php
    include '../includes/footer.php';
?>