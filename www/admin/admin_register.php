<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php
  include "include/db.php";
  include "include/header.php";
  include "include/function.php";

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
    if(empty($_POST['password'])){
      $error ['password']= "Please fill in your Password";
    }
    if(empty($_POST['pword'])){
      $error ['pword']= "Please re-enter your password";
    }
    if($_POST['password'] !== $_POST['pword']){
      $error ['pword']="Please your pass word do not match";
    }
    if(empty($error)){

      $new = array_map('trim', $_POST);

      adminRegister($conn, $new);
      echo "Registration is successful";
    }
  }
  ?>
  <div class="wrapper">
    <h1 id="register-label">Register</h1>
    <hr>
    <form id="register"  action ="admin_register.php" method ="POST">
      <div>
        <?php  $showError = displayError($error, 'fname'); echo $showError;  ?>
        <label>first name:</label>
        <input type="text" name="fname" placeholder="first name">
      </div>
      <div>
          <?php  $showError = displayError($error, 'lname'); echo $showError;  ?>
        <label>last name:</label>
        <input type="text" name="lname" placeholder="last name">
      </div>

      <div>
       <?php  $showError = displayError($error, 'email'); echo $showError;  ?>
        <label>email:</label>
        <input type="text" name="email" placeholder="email">
      </div>
      <div>
        <?php  $showError = displayError($error, 'password'); echo $showError;  ?>
        <label>password:</label>
        <input type="password" name="password" placeholder="password">
      </div>

      <div>
          <?php  $showError = displayError($error, 'pword'); echo $showError;  ?>
        <label>confirm password:</label>
        <input type="password" name="pword" placeholder="password">
      </div>

      <input type="submit" name="register" value="register">
    </form>

    <h4 class="jumpto">Have an account? <a href="admin_login.php">login</a></h4>
  </div>
  <?php
  include "include/footer.php";

  ?>

</body>
</html>
