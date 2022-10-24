<?php
    include '../includes/header.php';
?>
<link rel="stylesheet" href="../styles/admin-registration.css?v=<?php echo time()?>">

  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form action="#">
        <div class="user-details">
          <div class="input-box">
            <span class="details">First name</span>
            <input type="text" id="fName" placeholder="Enter your first name" required>
          </div>
          <div class="input-box">
            <span class="details">Last name</span>
            <input type="text" id="lName" placeholder="Enter your last name" required>
          </div>
          <div class="input-box">
            <span class="details">Position</span>
            <select id="position">
                <option value="">Select Position</option> <!--Can change the text(the white one) but don't change the value. Can also remove this line-->
                <option value="admin">Administrator</option><!--Can change the text(the white one) but don't change the value-->
                <option value="kitchen">Kitchen</option><!--Can change the text(the white one) but don't change the value-->
                <option value="cashier">Cashier</option><!--Can change the text(the white one) but don't change the value-->
            </select>
          </div>
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" id="username" placeholder="Enter your username" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" id="password" placeholder="Enter your password" required>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" id="passwordConf" placeholder="Confirm your password" required>
          </div>
        </div>
        <div class="button">
          <a href="./login.php" class="btnLOG">LOGIN</a>
          <input type="submit" value="REGISTER" id="btnSubmit">
        </div>
      </form>
    </div>
  </div>

<script src="../js/admin-registration.js?v=<?php echo time()?>"></script>
<?php
    include '../includes/footer.php';
?>