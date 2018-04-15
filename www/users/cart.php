<?php 
  include "include/db.php";
  include "include/function.php";
  include "include/header2.php";
  session_start();
   $user_id = $_SESSION['user_id'];
    $getCartInfo = viewCartInfoForUpdate($conn, $user_id);


$error = [];
if(array_key_exists('submit', $_POST)){
  if(empty($_POST['edit']) || !is_numeric($_POST['edit'])){
    $error['edit'] = "Please enter an  intiger value"; 
  }
  if(empty($error)){
    $info = array_map('trim', $_POST);
   
    $info['cart_id'] = $getCartInfo['cart_id'];
    updateCartQuantity($conn, $info, $user_id);

  }
}
 ?>
  <!-- main content starts here -->
  <div class="main">
    <table class="cart-table">
      <thead>
         <?php  $showError = displayError($error, 'edit'); echo $showError;  ?>
        <tr>
          <th><h3>Item</h3></th>
          <th><h3>Price</h3></th>
          <th><h3>Quantity</h3></th>
          <th><h3>Total</h3></th>
          <th><h3>Update</h3></th>
          <th><h3>Remove</h3></th>
        </tr>
      </thead>
      <tbody>
        <?php $showCartInfo = viewCartInfo($conn, $user_id);  echo $showCartInfo; ?>
      </tbody>
    </table>
    <div class="cart-table-actions">
      <button class="def-button previous">previous</button>
      <button class="def-button next">next</button>
      <div class="index">
        <a href="#"><p>1</p></a>
        <a href="#"><p>2</p></a>
        <a href="#"><p>3</p></a>
      </div>
      <a href="checkout.html"><button class="def-button checkout">Checkout</button></a>
    </div>
    
  </div>
  <!-- footer starts here -->
 <?php 

 include "include/footer.php";
  ?>



 