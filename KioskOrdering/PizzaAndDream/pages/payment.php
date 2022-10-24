<?php
    include '../includes/header.php';
    setPageStatus("payment");

    $selectObj = new Select();

    $tableNo = $_SESSION['TABLE_NO'];
    $items = file_get_contents('../../Cart.json');
    $items = json_decode($items, true);
    $foodItems = $items[$tableNo]['FoodItems'];
    $promoItems = $items[$tableNo]['PromoItems'];
    $totalPrice = 0;

    for($i = 0; $i < count($foodItems); $i++){
        $totalPrice += $foodItems[$i]['TotalPrice'];
    }
    for($i = 0; $i < count($promoItems); $i++){
        $promo = $selectObj->getPromoByPromoID($promoItems[$i]['PromoID']);
        $totalPrice += $promo['Price'];
    }
?>
<link rel="stylesheet" href="../styles/payment.css?v=<?php echo time()?>">

    <div>
        <h1 class="title">Payment</h1>
    </div>

    

        <div class="btn-bill">
            <div>   
                <h1 class="total-payment">Total Payment</h1>
                <h1 class="Total-price">₱ <?php echo number_format($totalPrice, 2, '.', '') ?></h1>
                <div class="mt-3 d-flex align-items-center justify-content-center">
                    <div class="flex-grow-1">
                        <h1 class="label-td">Date</h1>
                        <h1 class="val-td"><?php echo date('D, M j, Y');?></h1>
                    </div>
                    <div class="flex-grow-1">
                        <h1 class="label-td">Time</h1>
                        <h1 class="val-td time"><?php echo date('g:i:s a'); ?></h1>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="hr-1">
                <div>
                    <h1 class="Pay-M">Payment Method</h1>
                </div>
        
        <div class="btn-Cash" data-mode="cash">  
                <h1 class="Cash">Cash</h1>
        </div>

        <div class="btn-GCash" data-mode="gcash">  
                <h1 class="GCash">GCash</h1>
        </div>

<hr class="line-2">


                <div>
                    <h1 class="Change-for">Change for:</h1>
                </div>
        
        <div class="btn-Change">  
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">₱</span>
            <input type="number" class="form-control" id="txtCash" step=".01" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
        </div>
        </div>

        <div class="btn-Pay-Orders">  
             <button id="Pay-Orders">Pay Order</button>
        </div>


<!-- QR Code -->
<div class="bg-pop-up">
    <div class="qr-content">
        <i class="fas fa-times" id="btnCancelQR"></i>
        <img src="../img/img_qr.jpg" class="img-thumbnail" width="350px">
        <div class="text-center mt-4">
            <button class="btn-done-qr disabled" disabled>Done</button>
        </div>
    </div>
</div>


<!-- Pop up Bill -->
<div class="bg-bill-pop-up">
    <div class="bill-content">
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
<input type="hidden" value="<?php echo number_format($totalPrice, 2, '.', '')?>" id="totalPrice">
<script src="../js/payment.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>