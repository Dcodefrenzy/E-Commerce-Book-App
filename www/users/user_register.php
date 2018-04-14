<?php
  include "include/db.php";
  include "include/function.php";
  include "include/header.php";


 $error = array();


  if(array_key_exists('register', $_POST)){

    if(empty($_POST['fname'])){
      $error ['fname']= "Please fill in your First name";
    }
    if(empty($_POST['lname'])){
      $error ['lname']= "Please fill in your Last name";
    }
    if(empty($_POST['email'])){
      $error ['email']= "Please fill in your Email";
    }
    if(doesEmailExist($conn, $_POST['email'])){
      $error ['email']= "Email already exsits";
    }
    if(empty($_POST['username'])){
      $error['username']= "Please fill your username";
    }
    if(empty($_POST['hash'])){
      $error ['hash']= "Please fill in your Password";
    }
    if($_POST['hash'] != $_POST['pword']){
      $error ['pword']= "Please your password do not match";
    }
    if(empty($_POST['pword'])){
      $error ['pword']="Please Re-enter your password";
    }
    if(empty($error)){

      $data = array_map('trim', $_POST);

      userRegister($conn, $data);
      echo "Registration is successful";
    }
  }

?>
    

    
  <!-- main content starts here -->
  <div class="main">
    <div class="registration-form">
      <form class="def-modal-form" method="POST">
        <div class="cancel-icon close-form"></div>
        <label for="registration-from" class="header"><h3>User Registration</h3></label>
        <input type="text" class="text-field first-name" name="fname" placeholder="Firstname">
        <?php  $showError = displayError($error, 'fname'); echo $showError;  ?>
        <input type="text" class="text-field last-name" name="lname" placeholder="Lastname">
        <?php  $showError = displayError($error, 'lname'); echo $showError;  ?>
        <input type="email" class="text-field email" name="email" placeholder="Email">
        <?php  $showError = displayError($error, 'email'); echo $showError;  ?>
        <input type="text" class="text-field username" name="username" placeholder="Username">
        <?php  $showError = displayError($error, 'username'); echo $showError;  ?>
        <input type="password" class="text-field password" name="hash" placeholder="Password">
        <?php  $showError = displayError($error, 'hash'); echo $showError;  ?>
        <input type="password" class="text-field confirm-password" name="pword" placeholder="Confirm Password">
        <?php  $showError = displayError($error, 'pword'); echo $showError;  ?>
        <input type="submit" class="def-button" name="register" value="Register">
        <p class="login-option"><a href="user_login.php">Have an account already? Login</a></p>
      </form>
    </div>
  </div>

<?php 

include "include/footer.php";

 ?>