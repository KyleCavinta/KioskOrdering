<?php
    include '../includes/header.php';

    if(str_contains($_GET['item-id'], "FOD")){
        $food = $selectObj->getFoodByFoodID($_GET['item-id']);
        $image = "../img/menu-items/" . $food['Image'];
        $name = $food['Name'];
        $category = $food['Category'];
        $price = $food['Price'];
        
        $sizes = $selectObj->getFoodSizesByCategory($category);
    }
    else{
        $promo = $selectObj->getPromoByPromoID($_GET['item-id']);
        $image = "../img/menu-items/" . $promo['Image'];
        $name = $promo['Name'];
        $price = $promo['Price'];

        $promoIncludes = $selectObj->getPromoIncludesByPromoID($_GET['item-id']);
    }
?>
<link rel="stylesheet" href="../styles/modification.css?v=<?php echo time()?>">

<input type="hidden" value="<?php echo $_GET['item-id']; ?>" id="itemID"> <!-- Food item ID -->
<input type="hidden" value="<?php echo $food['Price'] ?? $promo['Price'] ?>" id="price">
<input type="hidden" value="<?php echo $category ?? "Promo" ?>" id="category">

<?php if(str_contains($_GET['item-id'], "FOD")): ?>
    <!-- Code ng FOOD -->
    <div class= img-exit>
        <img src = "../img/exit.png" width = 30px>
    </div>


    <div class = img-food>
        <img src= "<?php echo $image?>"  width ="100%"> 
    </div>

    <div class = "pizza-type">
        <?php echo $name?>
    </div>

    <div class = "modify">
        <div class = "options">
        <br>Options
        </div>

    <div class= "pizza-size">

        <div class="select-pizza">
            <label>CHOOSE <span style="font-weight: 600;"><?php echo strtoupper($category)?></span> SIZE</label>
            <select>
                <?php if(count($sizes) > 0): ?>
                    <?php for($i = 0; $i < count($sizes); $i++): ?>
                        <option value='{"size": "<?php echo $sizes[$i]['SizeID']?>", "description": "<?php echo $sizes[$i]['Description']?>"}'>
                            <?php echo $sizes[$i]['Size'] . " " . $sizes[$i]['Description']; ?>
                        </option>
                    <?php endfor; ?>
                <?php else: ?>
                    <option value='{"size": "", "description": ""}'>No available size</option>
                <?php endif; ?>
            </select>
        </div>


        <div class= quantity>
            <button class= "sub" id="btn-decrement"><i class="fas fa-minus"></i></button>
            <input type = " text" id = "num-quantity" value = "1" readonly>
            <button class = "add" id="btn-increment"> <i class="fas fa-plus"></i> </button>

            <div class = "total"> Total: 
                <div class = "price">₱ <?php echo $food['Price']; ?> </div>
            </div>
        </div>

        <button class="cart">
            <img src = "../img/ic_cart.png" width = 40px> Add to cart
        </button>
    </div>
<?php else: ?>

    <!-- Code ng PROMO -->

            <div class= img-exit>
                <img src = "../img/exit.png" width = 30px>
            </div>

            <div class = "img-promo">
                <img src= "<?php echo $image?>"  width = "100%"> 
            </div>

            <div class = "promo-type">
                <?php echo $name?>
            </div>

            <div class = "promo-modify">
                <div class = "options-pro">
                    <h4>Options
                </div>

        

        <div class= "promo-bundle">
            <?php for($i = 0; $i < count($promoIncludes); $i++): ?>

                <?php for($j = 0; $j < $promoIncludes[$i]['Quantity']; $j++): ?>
                    <?php $foodIncluded = $selectObj->getFoodsByCategoryAndMinPrice($promoIncludes[$i]['Category']); ?>

                    <h6 class="my-3" style="font-size: 23px;">CHOOSE YOUR <span style="font-weight: 600;"><?php echo strtoupper($promoIncludes[$i]['Category']) ?></span> FLAVOR
                    <div class="choose">
                        <select>
                            <?php for($k = 0; $k < count($foodIncluded); $k++): ?>

                                <option value="<?php echo $foodIncluded[$k]['FoodID']?>">
                                    <?php echo $foodIncluded[$k]['Name']?>
                                </option>
                                
                            <?php endfor; ?>
                        </select>
                    </div>

                <?php endfor; ?>
                <div style="height: 25px;"></div>
            <?php endfor; ?>
    </div>

    <div class = "promo-total"> Total: <?php echo $price;?>
        <div class = "price"> </div>
    </div>
        
        <button class="promo-cart">
            <img src = "../img/ic_cart.png" width = 40px> Add to cart
        </button>
<?php endif; ?>

<script src="../js/modification.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>