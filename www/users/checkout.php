<?php 
include "include/db.php";
include "include/function.php";
include "include/header.php";

  session_start();
  $user_id = $_SESSION['user_id'];
  $total_price = "";
  //Called In $total from function.php and it holds an array.
  $cartInfo = getCartInfoForCheckout($conn, $user_id);
  
  $price = (int)str_replace('$', '', $cartInfo[0]);
  $price2 = (int)str_replace('$', '', $cartInfo[1]);
  
  
  $total_price = $price + $price2;
 



  $error = array();
    if(array_key_exists('checkout', $_POST)){
      if(empty($_POST['phonenumber'])){
        $error['phonenumber']="Please input phonenumber";
      }
      if(!is_numeric($_POST['phonenumber'])){
        $error['phonenumber']="Please input a numeric value";
      }
      if(empty($_POST['adress'])){
        $error['adress']="Please enter a valid Adress";
      }
      if(empty($_POST['post_code'])){
        $error['post_code']="Please enter your Postal Code";
      }if(empty($error)){

          $data = array_map('trim', $_POST);
          $data['price'] = "$".$total_price;
          $data['user_id'] = $user_id; 
        insertIntoCkeckout($conn, $data);
    }
  }
 ?>
 
  <!-- main content starts here -->
  <div class="main">
    <div class="checkout-form">
      <form class="def-modal-form" method="POST">
        <div class="total-cost">
          <h3><?php echo "$".$total_price.' Total Purchase'?></h3>
        </div>
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Checkout</h3></label>
        <input type="text" name="phonenumber" class="text-field phone" placeholder="Phone Number">
        <?php  $showError = displayError($error, 'phonenumber'); echo $showError;  ?>
        <input type="text" name="adress" class="text-field address" placeholder="Address">
        <?php  $showError = displayError($error, 'adress'); echo $showError;  ?>
        <input type="text" name="post_code" class="text-field post-code" placeholder="Post Code">
        <?php  $showError = displayError($error, 'post_code'); echo $showError;  ?>
        <input type="submit" name="checkout" class="def-button checkout" value="Checkout">
      </form>
    </div>
  </div>
  <!-- footer starts here-->
  <?php 
  include "include/footer.php";
   ?>