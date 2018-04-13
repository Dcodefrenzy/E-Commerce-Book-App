
    <?php
    $page_title ="Edit Category";
    session_start();
      include "include/db.php";
      include "include/function.php";
      include "include/nav.php";


      authentication($_SESSION);
        $category = $_GET['cat_id'];
        $cat = getcategorybyid($conn, $category);

      $error= [];
      if(array_key_exists('add_category', $_POST)){
        if(empty($_POST['category_name'])){
          $error['category_name'] = "Please input a category name";
        }
        if(empty($error)){
          $input= array_map('trim', $_POST);
          editCategory($conn, $input, $category);
        }
      }


     ?>
     <div class="wrapper">
   		<h1 id="register-label">Edit Category</h1>
   		<hr>

   		<form id="register"  method="post">
   			<div>
             <?php  $showError = displayError($error, 'category_name'); echo $showError;  ?>
   				<label>Category Name:</label>
   				<input type="text" name="category_name" placeholder=<?php echo $cat[1] ?>>
   			</div>
   			<input type="submit" name="add_category" value="add">
   		</form>

   	</div>
  	</div>
<?php include "include/footer.php"; ?>

  </body>
</html>
