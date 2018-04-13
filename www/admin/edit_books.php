<?php

$page_title="Edit Book";
session_start();

  include "include/db.php";
  include "include/function.php";
  include "include/nav.php";


authentication($_SESSION);
  $id = $_GET['book_id'];
  $getbooks = getBookById($conn, $id);


$error = [];
$flag = ['Top selling', 'Trending', 'resently viewed' ];


if (array_key_exists('submit', $_POST)){

  if(empty($_POST['title'])){
    $error['title'] = "please input a Title";
  }

  if(empty($_POST['author'])){
    $error['author'] = "Please Input an Author";
  }
  if(empty($_POST['price'])){
    $error['price'] = "Please Input an Price";
  }

  if(empty($_POST['year'])){
    $error['year'] =  "Please Input an Year";
  }
  if(empty($_POST['category'])){
    $error['category'] = "Please Input an Category";
  }
  if(empty($_POST['flag'])){
    $error['flag'] = "Please Input an Flag";
  }
  if(empty($error)){
  $data = array_map('trim', $_POST);
  editBooks($conn, $id, $data);
}
}
 ?>

 <div class="wrapper">
<h1 id="register-label">Edit Book</h1>
<hr>
<form id="register" action="" method ="POST">
<div>
<?php
$showError = displayError($error, 'title');
echo $showError;
?>
<label>title:</label>
<input type="text" name="title" value=<?php echo $getbooks['title']; ?>>
</div>

<div>
<?php
$showError = displayError($error, 'author');
echo $showError;
?>
<label>author:</label>
<input type="text" name="author" value=<?php echo $getbooks['author']; ?>>
</div>

<div>
<?php
$showError = displayError($error, 'price');
echo $showError;
?>
<label>price:</label>
<input type="text" name="price" value=<?php echo $getbooks['price']; ?>>
</div>

<div>
<?php
$showError = displayError($error, 'year');
echo $showError;
?>
<label>publication dat:</label>
<input type="text" name="year" value=<?php echo $getbooks['pub_date']; ?>>
</div>

<div>
  <?php
$showError = displayError($error, 'category');
echo $showError;
   ?>
   <label>Categories</label>
   <select name="category">
     <option value="">select Category</option>

     <?php
     $data = selectCategory($conn);
     echo $data;
      ?>
    </select>

  </div>

<div>
  <?php
  $showError = displayError($error, 'flag');
  echo $showError;
  ?>
<label>Flag</label>
<select name="flag">
<option value="">Select Type</option>
<?php foreach ($flag as $fl){

echo '<option value="'.$fl.'">'.$fl.'</option>';
}
?>

</select>
</div>
<div>

<input type="submit" name="submit" value="Edit Book">
</form>
<a href="">click to edit book image</a>
</div>











<?php

  include "include/footer.php";
 ?>
