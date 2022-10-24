<?php
    include '../includes/header.php';
?>
<link rel="stylesheet" href="../styles/index.css?v=<?php echo time()?>">
<input type="hidden" value="<?php echo $_GET['tbl']?>" id="tableNo">

<div class="main">
    <div class = "logo" >
        <img src = "../img/img_logo.png" width = "600px">
    </div>
    <button>Get Started</button>
</div>

<script src = "../js/index.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>