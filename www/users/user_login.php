<?php 
include "include/db.php";
include "include/function.php";
include "include/header.php";

      session_start();

    $error = array();
    if(array_key_exists('login', $_POST)){
      if(empty($_POST['email'])){
        $error['email']="Please input email";
      }if(empty($_POST['hash'])){
        $error['hash']="Please enter a verified password";
      }if(empty($error)){

          $input = array_map('trim', $_POST);
       $response = userlogin($conn, $input);

       if($response[0]){
         $user = $response[1];
         header("Location:index.php");

         $_SESSION['user_id']= $user['user_id'];
         $_SESSION['firstname']= $user['firstname'];
         $_SESSION['lastname']= $user['lastname'];
         $_SESSION['username']= $user['username'];
         $_SESSION['email']= $user['email'];

       }else{
        $error['email'] = "Please enter a valid email";
        $error['hash'] = "please enter a valid password";
       }


      }
    }

 ?>
 




  <!-- main content starts here -->
  <div class="main">
    <div class="login-form">
      <form class="def-modal-form" method="POST">
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Login</h3></label>
        <input type="text" class="text-field email" name="email" placeholder="Email">
        <?php  $showError = displayError($error, 'email'); echo $showError;  ?>
        <input type="password" class="text-field password" name="hash" placeholder="Password">
        <?php  $showError = displayError($error, 'hash'); echo $showError;  ?>
        <!--clear the error and use it later just to show you how it works -->
        <input type="submit" class="def-button login" name="login" value="Login">
         <p class="login-option"><a href="user_register.php"> Don't Have an account? Register</a></p>
      </form>
    </div>
  </div>

  <?php 

  include "include/footer.php";

   ?>
  