<?php
    include '../includes/header.php';

    $categories = $selectObj->getCategories();

    $tableNo = $_SESSION['TABLE_NO'];

    $items = file_get_contents('../../Cart.json');
    $items = json_decode($items, true);
    $foodItems = $items[$tableNo]['FoodItems'];
    $promoItems = $items[$tableNo]['PromoItems'];
    
    setPageStatus("menu");
?>
<link rel="stylesheet" href="../styles/menu.css?v=<?php echo time()?>">

<div class="container-fluid">
    <!-- Top -->
    <div class="cart-icon">
        <img src="../img/ic_cart.png" width="60px" height="60px">
        <?php if((count($foodItems) + count($promoItems)) > 0): ?>
            <span><?php echo count($foodItems) + count($promoItems); ?></span>
        <?php endif; ?>
    </div>
        
    <h1 class="welcome">Welcome to</h1>
    <h1 class="title">Pizza & Dream</h1>

    <!-- Search -->
    <div class="mt-5">
        <input type="text" class="input-search" placeholder="What are you looking for?">
    </div>

    <!-- Categories -->
    <div class="food-category mt-5">
        <ul>
            <li>
                <a data-category="">All</a>
            </li>
            <?php foreach($categories as $category): ?>
                <li>
                    <a data-category="<?php echo $category['Category']?>">
                        <?php echo $category['Category']?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li>
                <a data-category="Promo">Promo</a>
            </li>
        </ul>
    </div>

    <!-- Food Items menu -->
    <div class="food-menu mt-2">
        <div class="inner-con">
        </div>
    </div>
</div>

<!-- Lighthouse -->
<div id="lighthouse">
    <div class="inner-lighthouse text-end">
        <i class="fas fa-times"></i>
        <div>
            <img width="550px">
            <h1 class="text-center"></h1>
        </div>
    </div>
</div>

<script src="../js/menu.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>