<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    session_start();
    include "include/db.php";
    include "include/header.php";
    include "include/function.php";

      $error = array();
    if(array_key_exists('register', $_POST)){
      if(empty($_POST['email'])){
        $error['email']="Please input email";
      }if(empty($_POST['password'])){
        $error['password']="Please enter password";
      }if(empty($error)){
          $input = array_map('trim', $_POST);
       $response = adminlogin($conn, $input);
       if($response[0]){
         $user = $response[1];
         header("Location:add_category.php");
         $_SESSION['admin_id']= $user['admin_id'];
         $_SESSION['firstname']= $user['firstname'];
         $_SESSION['lastname']= $user['lastname'];
         $_SESSION['email']= $user['email'];

       }


      }
    }

    ?>
    <div class="wrapper">
  		<h1 id="register-label">Admin Login</h1>
  		<hr>
  		<form id="register"  method="post">
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

  			<input type="submit" name="register" value="login">
  		</form>

  		<h4 class="jumpto">Don't have an account? <a href="admin_register.php">register</a></h4>
  	</div>

<?php include "include/footer.php"; ?>
  </body>
</html>
