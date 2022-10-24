<?php
    session_start();
    include '../includes/header.php';
    
    if(!isset($_SESSION['ADMIN_ID'])){
        header('location: login.php');
        exit();
    }
    
    $tables = $selectObj->getTables();
?>
<link rel="stylesheet" href="../styles/cashier.css?v=<?php echo time()?>">

<div class= "table-part">
    <div class = "container">
        <div class="d-flex align-items-baseline justify-content-between">
            <h2 class="title"><b>Pizza</b> & Dream</h2> 
            <i class="fas fa-power-off" id="btnLogout"></i>
        </div>
        <div class=table-line></div>
        <div class= row>
   
        <?php for($i = 0; $i < count($tables); $i++): ?>
            <div class="col-sm-4 col-sm-6 col-md-6  col-xl-4">
    <div class="cus-table" data-table-no="<?php echo $tables[$i]['TableNo']?>">
    <span class="badge rounded-pill bg-info text-dark" style="text-transform:capitalize;"></span>
        <h5 class="tbl-no"><?php echo $tables[$i]['TableNo']?></h5>
        </div>
            </div>
        <?php endfor ?>
            

        </div>

    </div>

</div>
 



        
       


<div class="info-part">
<i class="far fa-clock" aria-hidden="true" >  </i> 
<h1 class="date">Saturday <span class="running-time"><?php echo date('l F j, Y | g:i:s a'); ?></span> </h1>

<h1 class="d-line"></h1>

                <h1 class="ref-1 ms-5"><b>Table </h1>
                <h1 class="ref-2 ms-5" id="tableNo">none</h1>

<h1 class="d-line"></h1>

<div class = "receipt p-3">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<h1 class="d-line"></h1>
            <div class="payment">
                <h1 class="prices">SubTotal: <b id="dispSubTotal"></b></h1>
                <br>
                <h1 class="prices">VAT (12%): <b id="dispTax"></b></h1>
                <br>
                <h1 class="prices">Total: <b id="dispTotalPrice"></h1>
                <h5 class="prices">Mode of Payment: <b id="dispPaymentMethod"></b></h5>
            </div>

<h1 class="d-line"></h1>

            <h1 class="total" id="dispAmountPaid"></h1>

    <button type= "button" class="checkout" id="btnCheckout" disabled>CHECKOUT</button>








</div>



<div class="confirm-container">
    <div class="content">
        <div class="header">
            <h5>Confirmation</h5>
        </div>
        <div class="body">
            <p class="mb-3 text-center">Are you sure you want to checkout the orders?</p>
            <div class="print-receipt" id="printableReceipt">
            </div>
        </div>
        <div class="footer">
            <button id="btnConfirmationNo">No</button>
            <button id="btnConfirmationYes">Yes</button>
        </div>
    </div>
</div>

<script src="../js/cashier.js?v=<?php echo time()?>"></script>
<?php 
    include '../includes/footer.php';
?>