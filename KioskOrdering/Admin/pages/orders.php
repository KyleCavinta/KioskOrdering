<?php
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<link rel="stylesheet" href="../styles/orders.css?v=<?php echo time()?>">

<div class="container-fluid">
    <h4 class="title">Orders History</h4>
    <div class="app-card">
        <div class="d-flex flex-wrap justify-content-between mb-1 gap-2 gap-md-0">
            <div class="d-flex gap-1">
                <select class="form-control" id="year">
                    <option value="">Year</option>
                    <?php for($i = 2020; $i <= 2030; $i++): ?>
                        <option value="<?=$i?>" <?=($i == date('Y')) ? "selected" : ""?>><?=$i?></option>
                    <?php endfor; ?>
                </select>
                
                <select class="form-control" id="month">
                    <option value="">Month</option>
                </select>
                
                <select class="form-control" id="day">
                    <option value="">Day</option>
                </select>
            </div>
            
            <div class="d-flex gap-1">
                <select class="form-control" id="tableNo">
                    <option value="">Table</option>
                    <option value="T01">T01</option>
                    <option value="T02">T02</option>
                    <option value="T03">T03</option>
                    <option value="T04">T04</option>
                </select>
                <select class="form-control" id="paymentMethod">
                    <option value="">Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="GCash">GCash</option>
                </select>
            </div>
        </div>
        <div class="tbl-container">
            <table>
                <thead>
                    <th>Transaction ID</th>
                    <th>Table No.</th>
                    <th>Payment Method</th>
                    <th>Order Price</th>
                    <th>Date</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetails">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>

<script src="../js/orders.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>