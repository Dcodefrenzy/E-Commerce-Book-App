<?php 
  include "include/db.php";
  include "include/function.php";
  include "include/header2.php";
  session_start();
   $user_id = $_SESSION['user_id'];
   $update_total = "";

 if(isset($_GET['cart_id'])){
  $cart_id = $_GET['cart_id'];
 }else{
      header("cart.php");
 }



  $error=[];
  if(isset($_GET['cart_id'])){
  $cart_id = $_GET['cart_id'];
}
$error = [];
if(array_key_exists('submit', $_POST)){
  if(empty($_POST['edit']) || !is_numeric($_POST['edit'])){
    $error['edit'] = "Please enter an  intiger value"; 
  }
  if(empty($error)){
    $info = array_map('trim', $_POST);
    if(isset($cart_id)){
    updateCartQuantity($conn, $info, $user_id, $cart_id);
    header("Location:cart.php");
      }
    }
  
  }


?>
  <!-- main content starts here -->
  <div class="main">
    <table class="cart-table">
      <thead>
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
        <tr>
          <?php  $data = viewCartInfoForUpdate($conn, $cart_id); 
          $row = $data-> fetch(PDO::FETCH_BOTH);
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
            <form class="update" method="POST">
              <input type="number" class="text-field qty" name="edit" value=<?php echo $quantity; ?>>
              <input type="submit" class="def-button change-qty"  name="submit" value="Change Qty">
            </form>
          </td>    
          <td>
            <?php  echo '<a href="index_delete.php?cart_id='.$cart_id.'" class="def-button remove-item">Remove Item</a>'?>
          </td>
        </tr>
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
  




 


 		  
         