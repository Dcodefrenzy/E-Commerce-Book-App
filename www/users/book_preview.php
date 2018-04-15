<?php 
include "include/db.php";
include "include/function.php";
include "include/header2.php";

session_start();


  if(isset($_SESSION['user_id']) && $_SESSION['username']) {
      $user_id = $_SESSION['user_id'];
      $username = $_SESSION['username'];
    }
      if (isset($_GET['book_id'])){
    $book_id = $_GET['book_id'];
    $bookInfo = getBooksByBookId($conn, $book_id);
    $bookInformation = getBooksByBookIdForCart($conn, $book_id);
     }

     if(array_key_exists('submit', $_POST)){
      $error = [];
      if(empty($_POST['amount']) || !is_numeric($_POST['amount'])){
        $error['amount'] = "You must enter a numeric value";
         }
      if(empty($error)){
        $cartInfo = array_map('trim', $_POST);
        $cartInfo['book_name'] = $bookInformation['title'];
        $cartInfo['img_path'] = $bookInformation['img_path'];
        $cartInfo['price'] = $bookInformation['price'];
        insertCartInfo($conn, $cartInfo, $user_id);
        header("Location:cart.php?user_id = $user_id");
      }
     }




 ?>




  <!-- main content starts here -->
  <div class="main">
    <?php if(isset($error)){$showError = displayError($error, 'amount'); 
    echo '<p class="global-error"'.$showError.'</p>' ;}?>
    <div class="book-display">
     <?php echo $bookInfo;  ?>
        
        <form method="POST">
          <label for="book-amout">Amount</label>
          <input type="number" class="book-amount text-field" name="amount">
          <input class="def-button add-to-cart" type="submit" name="submit" value="Add to cart">
        </form>
      </div>
    </div>
    <?php 
      
    if(array_key_exists('send', $_POST)){   
      $error = [];
  if(empty($_POST['comment'])){
    $error['comment'] = "Please Input a comment";
  }
  if(empty($error)){
    $comment = array_map('trim', $_POST);
    insertComment($conn, $comment, $user_id, $username);
    header("Location:book_preview.php?book_id=$book_id");
  }
}


     ?>
    <div class="book-reviews">
      <h3 class="header">Reviews</h3>
      <ul class="review-list">
   
        <?php  $showComments = viewComment($conn); echo $showComments; ?>


      </ul>
   
      <div class="add-comment">
        <h3 class="header">Add your comment</h3>
        <form class="comment" method="POST">
          <?php  if(isset($error)){$showError = displayError($error, 'comment'); 
          echo '<p class="global-error"'.$showError.'</p>' ;}?>  
          <textarea  class="text-field" name="comment" placeholder="write something" ></textarea>
          <button class="def-button post-comment" type="submit" name="send">Upload comment</button>
        </form>
      </div>
    </div>
  </div>
 
  <?php 

  include "include/footer.php";

   ?>
