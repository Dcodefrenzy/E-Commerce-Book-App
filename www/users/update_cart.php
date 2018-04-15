<?php 
 



if(isset($_GET['cart_id'])){
	$cart_id = $_GET['cart_id'];
}





 ?>


 		  <td>
            <form class="update" method="POST">
              <input type="number" class="text-field qty" name="edit">
              <input type="submit" class="def-button change-qty"  name="submit" value="Change Qty">
            </form>
          </td> 
          <td>
            <a href="cart_delete.php?cart_id='.$row['cart_id'].'" class="def-button remove-item">Remove Item</a>
          </td>
        </tr>