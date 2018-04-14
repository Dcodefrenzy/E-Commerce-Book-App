<?php 
include "include/db.php";
include "include/function.php";
include "include/header2.php";

session_start();



      $book_id = $_GET['book_id'];


     $_SESSION['user_id'];
     $_SESSION['firstname'];
     $_SESSION['lastname'];
     $_SESSION['email'];
     $_SESSION['username'];

     

     if(array_key_exists('submit', $_POST)){
      $error = [];
      if(empty($_POST['amount']) || !is_numeric($_POST['amount'])){
        $error['amount'] = "You must enter a numeric value";
        var_dump($error);
      }
      if(empty($error)){

      }
     }



 ?>




  <!-- main content starts here -->
  <div class="main">
    <?php  if(isset($error)){$showError = displayError($error, 'amount'); echo '<p class="global-error"'.$showError;'></p>' ;}?>
    <div class="book-display">
      <div class="display-book"></div>
      <div class="info">
        <h2 class="book-title">Javascript &amp; Jquery </h2>
        <h3 class="book-author">by Jon Duckett</h3>
        <h3 class="book-price">$125</h3>
        <form method="POST">
          <label for="book-amout">Amount</label>
          <input type="number" class="book-amount text-field" name="amount">
          <input class="def-button add-to-cart" type="submit" name="submit" value="Add to cart">
        </form>
      </div>
    </div>
    <div class="book-reviews">
      <h3 class="header">Reviews</h3>
      <ul class="review-list">
        <li class="review">
          <div class="avatar-def user-image">
            <h4 class="user-init">jm</h4>
          </div>
          <div class="info">
            <h4 class="username">Jon Williams</h4>
            <p class="comment">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit,
              sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
        </li>
        <li class="review">
          <div class="avatar-def user-image">
            <h4 class="user-init">AE</h4>
          </div>
          <div class="info">
            <h4 class="username">Abby Essien</h4>
            <p class="comment">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit,
              sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              Lorem ipsum dolor sit amet, consectetur adipisicing elit,
              sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
        </li>
        <li class="review">
          <div class="avatar-def user-image">
            <h4 class="user-init">SB</h4>
          </div>
          <div class="info">
            <h4 class="username">Sandra Bullock</h4>
            <p class="comment">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit,
              sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              Lorem ipsum dolor sit amet, consectetur adipisicing elit,
              sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
        </li>
      </ul>
      <div class="add-comment">
        <h3 class="header">Add your comment</h3>
        <form class="comment" method="POST">
          <textarea class="text-field" placeholder="write something"></textarea>
          <button class="def-button post-comment" type="submit" name="comment">Upload comment</button>
        </form>
      </div>
    </div>
  </div>
 
  <?php 

  include "include/footer.php";

   ?>
