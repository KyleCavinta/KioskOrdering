<?php
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<link rel="stylesheet" href="../styles/dashboard.css?v=<?php echo time()?>">

<div class="text-1">
    <h4 class="note">Welcome to Dashboard <h4>
        <hr class="line-1">
</div>
<div class="cardBox">
        <!-- today sales -->
    <div class="card">
        <div>
            <div id="TodaySales" class="numbers"></div>
            <div class="cardName">Today's Sales</div>
        </div>
        <div class="iconBx">
            <ion-icon name="cart-outline"></ion-icon>
        </div>
        </div>    
        <!-- today served -->
    <div class="card">
        <div>
            <div  id = "TodayServed" class="numbers"></div>
            <div class="cardName">Today's Served</div>
        </div>
        <div class="iconBx">    
            <ion-icon name="restaurant-outline"></ion-icon>
        </div>
    </div>
        <!-- aveVAlue -->
    <div class="card">
        <div>
            <div id= "AOValue" class="numbers"></div>
            <div class="cardName">Ave. Order Value</div>
        </div>
        <div class="iconBx">    
            <ion-icon name="pie-chart-outline"></ion-icon>
        </div>
    </div>  
        <!-- Yesterday sale  -->
    <div class="card">
        <div>
            <div id="YestSale" class="numbers"></div>
            <div class="cardName">Yesterday's Sales</div>
        </div>
        <div class="iconBx">      
            <ion-icon name="document-text-outline"></ion-icon>
        </div>
    </div>
</div> 

<!-- chart -->

    <div class="graphBox">
        <div class="box">
        <canvas id="myChart"></canvas>
        </div>
        <div class="box">
        <canvas id="earning"></canvas>
        </div>
    </div>



<div class = "details">
    <!-- order datails list -->
        <div class="recentOrders">
            <div class="cardHeader">
                <h2> Recent Orders</h2>
                <a href="../pages/orders.php" class="btn"> View All</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Date</td>
                        <td>Table</td>
                        <td>Payment Method</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- statistic -->
        <div class ="container-2">
            <div class="stats-2">
                <h2 class="feedback">Feedback</h2>
            </div>
            <canvas id="stats"></canvas>
        <div>
    </div>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script src="../js/dashboard.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>