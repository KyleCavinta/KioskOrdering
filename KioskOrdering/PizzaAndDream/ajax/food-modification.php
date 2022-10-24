<?php
    include '../includes/class-loader.php';
    session_start();
    $selectObj = new Select();
    
    $orders = json_decode(file_get_contents('../../Cart.json'), true)[$_SESSION['TABLE_NO']];
    $foodItem = $orders['FoodItems'][$_POST['index']];
    
    $food = $selectObj->getFoodByFoodID($foodItem['FoodID']);
    $sizes = $selectObj->getFoodSizesByCategory($food['Category']);
?>

<link rel="stylesheet" href="../styles/food-modification.css?v=<?php echo time()?>">

<div class="header">
    <h5 class="title"><?php echo $food['Category']?></h5>
</div>

<div class="body">
    <img src="../img/menu-items/<?php echo $food['Image']?>">
    <h1 class="text-center mt-2"><?php echo $food['Name']?></h1>
    
    <label>Size</label>
    <select id="selectSize">
        <?php foreach($sizes as $size): ?>
            <option data-desc="<?php echo $size['Description']?>" value="<?php echo $size['SizeID']?>" <?php echo ($size['SizeID'] == $foodItem['Size']) ? "selected" : ""?>>
                <?php echo $size['Description']?>
            </option>
        <?php endforeach ?>
    </select>
    
    <div class="spinner-total">
        <div class="spinner">
            <button id="btnDecrement">-</button>
            <input type="text" id="quantity" value="<?php echo $foodItem['Quantity']?>" readonly>
            <button id="btnIncrement">+</button>
        </div>
        
        <div class="d-flex align-items-center">
            <sup class="me-3">Total</sup>
            <h2 id="totalPrice">₱ <?php echo $foodItem['TotalPrice']?></h2>
        </div>
    </div>
    
    <div class="text-end mt-2">
        <small><?php echo ucwords($foodItem['ServiceStatus'])?></small>
    </div>
</div>

<div class="footer">
    <button id="btnCancel">Cancel</button>
    <button id="btnRemove" style="background:#CA0B00;">Remove</button>
    <button id="btnEdit">Edit</button>
</div>

<input type="hidden" id="itemIndex" value="<?php echo $_POST['index']?>">
<input type="hidden" id="totalPrice" value="<?php echo $foodItem['TotalPrice']?>">
<input type="hidden" id="origPrice" value="<?php echo $food['Price']?>">
<script>$.getScript('../js/food-modification.js')</script>