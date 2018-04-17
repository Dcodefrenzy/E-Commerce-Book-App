<?php 
include "include/db.php";
include "include/class.viewed.php";
include "include/function.php";
include "include/header2.php";

session_start();
   $user_id =$_SESSION['user_id'];
 
  $view_index =  new ViewInIndex;
  $view_index->GetFromAddBook($conn, 'Top selling');
  $view_topselling =$view_index ->flag; 

  extract($view_topselling);

  if(array_key_exists('submit', $_POST)){
      $error = [];

      if(empty($_POST['amount']) || !is_numeric($_POST['amount'])){
        $error['amount'] = "You must enter a numeric value";
         }
      if(empty($error)){

        $cartInfo = array_map('trim', $_POST);
        $cartInfo['book_name'] = $title;
        $cartInfo['img_path'] = $img_path;
        $cartInfo['price'] = $price; 
        insertCartInfo($conn, $cartInfo, $user_id);
        header("Location:cart.php");
      }
     }


  ?> 
  <!-- main content starts here -->

  <div class="main">
    <?php if(isset($error)){$showError = displayError($error, 'amount');
            echo '<p class="global-error"'.$showError.'</p>' ;}  ?>
    <div class="book-display">
      <div class="display-book" style="background-image:url(<?php echo $img_path ?>); 
                                      background-size:cover; 
                                      background-position:center; 
                                      background-repeat: no-repeat">                                  
      </div>
      <div class="info">
        <h2 class="book-title"><?php echo $title  ; ?></h2>
        <h3 class="book-author"><?php echo "by ".$author; ?></h3>
        <h3 class="book-price"><?php echo $price ;?></h3>

        <form method="POST">
          <label for="book-amount">Amount</label>
          <input type="number" class="book-amount text-field" name="amount" >
          <input class="def-button add-to-cart" type="submit" name="submit" value="Add to cart">
        </form>
      </div>
    </div>
    <div class="trending-books horizontal-book-list">
      <h3 class="header"> Trending </h3>
      <ul class="book-list">
        <?php $view_trending =viewTrendingInfofromBooks($conn, 'Trending'); echo $view_trending; ?>  
      </ul>
    </div>
    <div class="recently-viewed-books horizontal-book-list">
      <h3 class="header">Recently Viewed</h3>
      <ul class="book-list">
        <?php   $showResentlyViewedBook =showRecentlyViewedBook($conn, $user_id); echo $showResentlyViewedBook ;?>
      </ul>
    </div>
    
  </div>

  <?php 

  include "include/footer.php";

   ?>
 
