<?php 
 



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
   
    }
  }


 ?>


 		  <td>
            <form class="update" method="POST">
              <input type="number" class="text-field qty" name="edit" value=<?php echo $cart_id; ?>
              <input type="submit" class="def-button change-qty"  name="submit" value="Change Qty">
            </form>
          </td> 
         