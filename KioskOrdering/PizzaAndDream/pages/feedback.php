<?php
    include '../includes/header.php';
    setPageStatus("feedback");
?>
<link rel="stylesheet" href="../styles/feedback.css?v=<?php echo time()?>">
            <div>  
                <img src = "../img/exit.png" width = 40px height="40px" class= img-exit id="exitFeedback">
                <h1 class="Feedback">How was your experience</h1>
                <h1 class="Feedback">with this mobile</h1>
                <h1 class="Feedback">app today?</h1> 
            </div>

            <div class="image-container">
                     <img src = "../img/PizzaE.png" width =40px height="40px" class= img-Emoji>
            </div>

            <div class="SelectValue">
                <h1 id="demo"></h1>
            </div>


        <div class="main">
            <input type="range" min="1" max="3" value="2" id="myRange" step="1">
            <div id="selector">
                <div class="SelectBtn"></div>
            </div>
        </div>


        <div class="btn-Done">
            <button id="btnDone">Done</button>
            <img src = "../img/like.png" width =40px height="40px" class= img-like>
        </div>

<input type="hidden" value="<?php echo $_SESSION['TABLE_NO']?>" id="tableNo">
<script src="../js/feedback.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>