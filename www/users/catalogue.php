<?php 
  include "include/db.php";
  include "include/function.php";
  include "include/header3.php";

  session_start();
   $user_id = $_SESSION['user_id'];
  $cat_id = $_GET['cat_id'];



 ?>

  <!-- side bar starts here -->
  <div class="side-bar">
    <div class="categories">
      <h3 class="header">Categories</h3>
      <ul class="category-list">
        <?php 
        $viewAllCategories = selectCategory($conn);
        echo $viewAllCategories; ?>
      </ul>
    </div>
  </div>
  <!-- main content starts here -->
  <div class="main">
    <div class="main-book-list horizontal-book-list">
      <ul class="book-list">
        <?php $showImageInCategory = getBookByCategory($conn, $cat_id); echo $showImageInCategory; ?>
      </ul>
      <div class="actions">
        <button class="def-button previous">Previous</button>
        <button class="def-button next">Next</button>
      </div>
    </div>
    <div class="recently-viewed-books horizontal-book-list">
      <h3 class="header">Recently Viewed</h3>
      <ul class="book-list">
        <div class="scroll-back"></div>
        <div class="scroll-front"></div>
        <?php $showRecentlyViewedBooks =showRecentlyViewedBook($conn, $user_id); echo $showRecentlyViewedBooks;?>
      </ul>
    </div>
    
    <?php 

      include "include/footer.php";
     ?>
 
