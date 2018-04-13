
    <?php
    $page_title ="Add Category";
    session_start();
      include "include/db.php";
      include "include/function.php";
      include "include/nav.php";


      authentication($_SESSION);
      //form validation.
      $error= [];
      if(array_key_exists('add_category', $_POST)){
        if(empty($_POST['category_name'])){
          $error['category_name'] = "Please input a category name";
        }
        if(empty($error)){
          $input= array_map('trim', $_POST);
          //called the function bellow to be able to insert category into our database.
          addCategory($conn, $input);
        }
      }


     ?>
     <?/*php here we created a form for add category,
      we also created a table called add_category on our database and on our table we have
      category_id amd category_name.*/
   ?>
     <div class="wrapper">
   		<h1 id="register-label">Add Category</h1>
   		<hr>
   		<form id="register"  method="post">
   			<div>
             <?php  $showError = displayError($error, 'category_name'); echo $showError;  ?>
   				<label>Category Name:</label>
   				<input type="text" name="category_name" placeholder="Category name">
   			</div>
   			<input type="submit" name="add_category" value="add">
   		</form>

   	</div>
  	</div>
<?php include "include/footer.php"; ?>

  </body>
</html>
