<?php
    session_start();
    include '../includes/header.php';
    
    if(!isset($_SESSION['ADMIN_ID'])){
        header('location: login.php');
        exit();
    }
    
    $selectObj = new Select();
    $tables = $selectObj->getTables();
?>
<link rel="stylesheet" href="../styles/kitchen.css?v=<?php echo time()?>">

<div class="table-part">
    <div class="container-fluid">
        <div class="row">
            <?php foreach($tables as $table): ?>
                <div class="col-12 col-sm-6 col-md-4 col-xl-6 col-xxl-4">
                    <div class="cus-table p-2" data-table-no="<?php echo $table['TableNo']?>">
                        <h6><?php echo $table['TableNo']?></h6>
                        <i class="far fa-bell">
                            <span class="position-absolute bg-danger rounded-circle">
                            </span>
                        </i>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div class="info-part">
    <div class="clock">
        <i class="far fa-clock me-2"></i>
        <span><?php echo date('l F j, Y | g:i:s a') ?></span>
        <p class="ms-auto" id="btnLogout"><i class="fas fa-power-off"></i></p>
    </div>
    
    <div class="table-details">
        <div>
            <h1>Table Number</h1>
            <h1 id="tableNo" style="color: #cfcfcf;"></h1>
        </div>
    </div>
    
    <div class="order-container">
        <h2>Orders</h2>
        <div class="orders">
            <table>
            </table>
        </div>
    </div>
        
    <div class="hr"></div>
    
    <div class="status-container">
        <h5 class="mt-3">Status</h5>
        <select>
            <option value="pending">Pending</option>
            <option value="preparing">Preparing</option>
            <option value="serving">Serving</option>
            <option value="enjoy">Enjoy</option>
        </select>
    </div>
</div>

<script src="../js/kitchen.js?v=<?php echo time(); ?>"></script>

<?php
    include '../includes/footer.php';
?>