<?php 
  include "include/db.php";
  include "include/function.php";
  include "include/header2.php";
  session_start();
   $user_id = $_SESSION['user_id'];
  
  $showCartInfo = viewCartInfo($conn, $user_id);
 
  $cart_id = $showCartInfo[0];
  
        
  
 


$error = [];
if(array_key_exists('submit', $_POST)){
  if(empty($_POST['edit']) || !is_numeric($_POST['edit'])){
    $error['edit'] = "Please enter an  intiger value"; 
  }
  if(empty($error)){
    foreach ($cart_id as $id) {
     $info = array_map('trim', $_POST);
     while( $cid=$id){
     updateCartQuantity($conn, $info, $user_id, $cid);
    }
}
    
   
   
   

 
  }
}
 ?>
  <!-- main content starts here -->
  <div class="main">
    <table class="cart-table">
      <thead>
         <?php  $showError = displayError($error, 'edit'); echo $showError; 

          ?>
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
        <?php $showCartInfo = viewCartInfo($conn, $user_id); 
              echo $showCartInfo[1] ;
        ?>

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
      <?php echo '<a href="checkout.php?cart_id='.$user_id.'"><button class="def-button checkout">Checkout</button></a>'?>
    </div>
    
  </div>
  <!-- footer starts here -->
 <?php 

 include "include/footer.php";
  ?>



 