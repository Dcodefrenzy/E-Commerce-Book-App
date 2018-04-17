<?php 
  include "include/db.php";
  include "include/function.php";
  include "include/header2.php";
  session_start();
  $record_per_page = 3;
  $page = '';
  if(isset($_SESSION['user_id'])){

   $user_id = $_SESSION['user_id'];
  }else{
    header("Location:user_login.php");
  }
 
  if(isset($_GET['cart_id'])){
  $cart_id = $_GET['cart_id'];
  }
  if(isset($_GET['page'])){
    $page = $_GET['page'];
  }else{
    $page = 1;
  }
  $start_from = ($page-1)*$record_per_page;

$error = [];
if(array_key_exists('submit', $_POST)){
  if(empty($_POST['edit']) || !is_numeric($_POST['edit'])){
    $error['edit'] = "Please enter an  intiger value"; 
  }
  if(empty($error)){
    $info = array_map('trim', $_POST);
    if(isset($cart_id)){
    updateCartQuantity($conn, $info, $user_id, $cart_id);
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
        <?php  

          $data = viewCartInfo($conn, $user_id, $start_from, $record_per_page); 
          while($row = $data-> fetch(PDO::FETCH_BOTH)){
            extract($row);
             ?>
            <tr>
          <td><div class="book-cover" style="background:url(<?php echo $item ?>); background-size: cover;
          background-position: center; background-repeat: no-repeat"></div></td>
          <td><p class="book-price"><?php echo $price ?></p></td>
         <td><p class="quantity"><?php echo $quantity ?></p></td>
         <?php  $amount = (int)str_replace('$', '', $price);  
                 $total = $amount * $quantity; ?>
          <td><p class="total"><?php echo "$".$total ?></p></td>
         
              <td>
          <?php echo '<a href="update_cart.php?cart_id='.$cart_id.'" class="def-button remove-item">Update Quantity</a>'?>   
          </td>    
          <td>
            <?php  echo '<a href="cart_delete.php?cart_id='.$cart_id.'" class="def-button remove-item">Remove Item</a>'?>
          </td>
            <?php } //Ending while loop?>
      </tbody>
    </table>
    <div class="cart-table-actions">
        <button class="def-button previous">previous</button></a>
        <button class="def-button next">next</button></a>' 
      <div class="index">
        <?php  $link = pagination($conn, $user_id,  $record_per_page); echo $link; ?>
      </div>
   
      <?php echo '<a href="checkout.php?user_id='.$user_id.'"><button class="def-button checkout">Checkout</button></a>'?>
    </div>
    
  </div>
  <!-- footer starts here -->
 <?php 

 include "include/footer.php";
  ?>



 