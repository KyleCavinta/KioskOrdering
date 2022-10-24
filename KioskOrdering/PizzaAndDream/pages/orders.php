<?php
    include '../includes/header.php';
    setPageStatus("orders");
    
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

    $tableNo = $_SESSION['TABLE_NO'];
    $items = file_get_contents('../../Cart.json');
    $items = json_decode($items, true);
    $foodItems = $items[$tableNo]['FoodItems'];
    $promoItems = $items[$tableNo]['PromoItems'];
    
    $statuses = array_merge(array_column($foodItems, "ServiceStatus"), array_column($promoItems, "ServiceStatus"));
    $totalPrice = 0;
?>
<link rel="stylesheet" href="../styles/orders.css?v=<?php echo time()?>">

    <div class="d-flex align-items-center mt-5 justify-content-between mx-auto" style="width: 650px;">
        <i class="fa fa-chevron-left" aria-hidden="true" id="btnBack"></i>
        <h1 class="orders">Orders</h1>
    </div>

    <div class="notify">
        <h1><?php echo ucwords(priorityStatus($statuses)) ?></h1>
    </div>

    <div class="orders-container">
        <?php for($i = 0; $i < count($foodItems); $i++): ?>
            <?php $food = $selectObj->getFoodByFoodID($foodItems[$i]['FoodID']); ?>
            <?php $size = $selectObj->getSizeBySizeID($foodItems[$i]['Size']); ?>
            <?php $totalPrice = $totalPrice + $foodItems[$i]['TotalPrice']; ?>
        <div class="container">

            <img src="../img/menu-items/<?php echo $food['Image']?>" width="115px" height="110px" class="HWN-icon">

        </div>

        <div class="orders">
            <div>   
                <h1 class="Meal"><?php echo $food['Name']?></h1>
                <h1 class="type"><?php echo $food['Category']?></h1>
                <h1 class="type">Size: <?php echo (isset($size['Size'])) ? ($size['Size'] . " " . $size['Description']) : ""?></h1>
                <h1 class="type">Quantity: <?php echo $foodItems[$i]['Quantity']?></h1>   
                <h1 class="HWN-price">₱ <?php echo $foodItems[$i]['TotalPrice']?></h1>

                <hr class="line-1">
            
            </div>
         </div>
        <?php endfor; ?>

        <?php for($j = 0; $j < count($promoItems); $j++): ?>
            <?php $promo = $selectObj->getPromoByPromoID($promoItems[$j]['PromoID'])?>
            <?php $totalPrice = $totalPrice + $promo['Price']; ?>
         <div class="container">
            <img src="../img/menu-items/<?php echo $promo['Image']?>" width="115px" height="110px" class="HWN-icon">

        </div>

        <div class="promo-bundle">
            <div>  

                <h1 class="Meal"><?php echo $promo['Name']?></h1>
            
                <?php for($i = 0; $i < count($promoItems[$j]['FoodIncluded']); $i++): ?>
                    <?php $food = $selectObj->getFoodByFoodID($promoItems[$j]['FoodIncluded'][$i]); ?>
                <h1 class="flavor-type">F<?php echo $i + 1 ?>: <?php echo $food['Name']; ?></h1>
                <?php endfor; ?>

                <h1 class="promo-price">₱ <?php echo $promo['Price']?></h1>

                <hr class="line-2">

            </div>
        </div>
        <?php endfor; ?>
    </div>
        <div class="btn-total">
            <button id="btnTotal">₱ <?php echo number_format($totalPrice, 2, '.', '')?></button>
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

<input type="hidden" value="<?php echo $_SESSION['TABLE_NO']?>" id="tableNo" disabled>
<script src="../js/orders.js?v=<?php echo time(); ?>"></script>
<?php
    include '../includes/footer.php';
?>