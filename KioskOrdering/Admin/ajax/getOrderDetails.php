<?php
    include '../includes/class-loader.php';
    $selectObj = new Select();
    $foodOrdered = $selectObj->getOrderedFoodByTransactionID($_POST['transactionID']);
    $promoOrdered = $selectObj->getOrderedPromoByTransactionID($_POST['transactionID']);
?>

<style>
    table.info tr th{
        padding-top: 3px;
        padding-bottom: 3px;
        padding-right: 30px;
    }
    
    table.item{
        width: 100%;
    }
    
    ul.promo li{
        margin: unset;
    }
</style>

<div class="modal-header">
    <h5 class="modal-title">Order Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="info">
        <tr>
            <th>Table# :</th>
            <td><?php echo $_POST['tblNo']?></td>
        </tr>
        <tr>
            <th>Transaction#: </th>
            <td><?php echo $_POST['transactionID']?></td>
        </tr>
        <tr>
            <th>Date:</th>
            <td><?php echo $_POST['date']?></td>
        </tr>
    </table>
    
    <h4 class="mt-4 fw-bold">Food Ordered</h4>
    <div class="overflow-auto">
        <table class="table table-success item">
            <thead>
                <th>Food ID</th>
                <th>Food Name</th>
                <th>Size</th>
                <th class="text-end">Quantity</th>
                <th>Total Price</th>
            </thead>
            <tbody>
                <?php foreach($foodOrdered as $food): ?>
                    <tr>
                        <td><?php echo $food['FoodID']?></td>
                        <td><?php echo $food['Name'] . " (" . $food['Category'] . ")"?></td>
                        <td><?php echo (is_array($selectObj->getSizeBySizeID($food['SizeID'])) ? $selectObj->getSizeBySizeID($food['SizeID'])['Description'] : "N/A")?></td>
                        <td class="text-end"><?php echo $food['Quantity']?></td>
                        <td><?php echo number_format($food['TotalPrice'], 2, ".", ",")?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <h4 class="mt-4 fw-bold">Promo Ordered</h4>
    <ul class="promo">
        <?php foreach($promoOrdered as $promo): ?>
            <li><?php echo $promo['Name']?> - Php <?php echo $promo['Price']?></li>
            <?php $includes = $selectObj->getIncludedFoodInPromo($promo['OrderID']);?>
            <ul>
                <?php foreach($includes as $include): ?>
                    <li><?php echo $include['Name'] . " (" . $include['Category'] . ")"?></li>
                <?php endforeach?>
            </ul>
        <?php endforeach?>
    </ul>
    
    <div class="text-end">
        Total Price: <span class="fw-bold"><?php echo $_POST['price']?></span>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>