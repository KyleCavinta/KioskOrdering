<?php
    include '../includes/header.php';
?>
<link rel="stylesheet" href="../styles/login.css?v=<?php echo time()?>">

<div class="container d-flex">
    
      <form class="border shadow p-3 rounded"
      style="width: 550px;" action="../php/LoginFunction.php" method="POST">
      <h1 class="text-center p-3">Pizza and Dream</h1>
      <?php if(isset($_GET['st'])): ?>
        <p style="text-align:center;" class="text-danger">Incorrect Username or Password</p>
        <?php endif; ?>
      <div class="mb-3">
    <label for="username" 
        class="form-label">Username</label>
    <input type="text" 
    class="form-control"
    name="username" 
    id="username">    
  </div>
  <div class="mb-3">
    <label for="password" 
        class="form-label">Password</label>
    <input type="password" 
        class="form-control"
        name="password" 
        id="password"> 
  </div>
  <div class="mb-1">
      <label class="form-label">Select User Type:</label>
</div>
<select class="form-select mb-3"
name="role"
aria-label="Default select example">
<option selected value="kitchen">Kitchen</option>
<option value="cashier">Cashier</option>
<option value="admin">Admin</option>
</select>
  <a href="admin-registration.php" class="btnreg">REGISTER</a>
  <button class="btnlog">LOGIN</button>
</form>


<?php
    include '../includes/footer.php';
?>