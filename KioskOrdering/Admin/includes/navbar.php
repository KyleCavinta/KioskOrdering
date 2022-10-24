<?php
    session_start();
    if(!isset($_SESSION['ADMIN_ID'])){
        header('location: ../pages/login.php');
        exit();
    }
?>
<link rel="stylesheet" href="../styles/navbar.css?v=<?php echo time()?>">


<div class="toggle">
    <i class="fas fa-bars"></i>
</div>
</div>

<div class="container">
    <div class="navigation" >
        <div class="close">
            <i class="fas fa-times" aria-hidden="true"></i>
        </div>
      <div class="shape">
        <img src="../img/logo.png" width="120px" height="170px" class="Logo"> 
      </div>
        <ul>
          <li>
            <a href="../pages/dashboard.php">
              <span class="icon"><i class="fal fa-home-alt"></i></span>
              <span class="title">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="../pages/orders.php">
              <span class="icon"><i class="fal fa-shopping-cart"></i></span>
              <span class="title">Orders</span>
            </a>
          </li>
          <li>
            <a href="../pages/reports.php">
              <span class="icon"><i class="fal fa-file-alt"></i></span>
              <span class="title">Reports</span>
            </a>
          </li>
          <li>
            <a href="#" id="navLogout">
              <span class="logout"><i class="fal fa-sign-out"></i></span>
              <span class="title">Logout</span>
            </a>
          </li>
        </ul>
    </div>
</div>


<!--Kailangan palaging nasa baba to ng mga code mo-->
<script src="../js/navbar.js?=<?php echo time()?>"></script>