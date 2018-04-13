<?php
$page_title ="Add Books";
session_start();

  include "include/db.php";
  include "include/function.php";
  include "include/nav.php";




authentication($_SESSION);


$error = [];
$flag = ['Top selling', 'Trending', 'resently viewed' ];
define("MAX_FILE_SIZE", 2097152);
$ext = ['image/jpeg', 'image/jpg', 'image/png'];

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
  if(empty($_FILES['img']['name'])) {
$error['img'] = "Please provide an image";
}

if($_FILES['img']['size'] > MAX_FILE_SIZE) {
$error['img'] = "File size exceeds maximum: ".MAX_FILE_SIZE;
}

if(!in_array($_FILES['img']['type'], $ext)) {
$error['img'] = "File format not supported";
}
if(empty($error)){
  $info =uploadFile($_FILES, 'img', 'uploades/');

  $location = "";
  if($info[0]){

  $location =   $info[1];
  }
  $data = array_map('trim', $_POST);


  $data['dest'] = $location;
  addBooks($conn, $data);
}
}
 ?>

 <div class="wrapper">
<h1 id="register-label">Add Book</h1>
<hr>
<form id="register" action ="add_books.php" method ="POST" enctype="multipart/form-data">
<div>
<?php
$showError = displayError($error, 'title');
echo $showError;
?>
<label>title:</label>
<input type="text" name="title" placeholder="title">
</div>

<div>
<?php
$showError = displayError($error, 'author');
echo $showError;
?>
<label>author:</label>
<input type="text" name="author" placeholder="author">
</div>

<div>
<?php
$showError = displayError($error, 'price');
echo $showError;
?>
<label>price:</label>
<input type="text" name="price" placeholder="price">
</div>

<div>
<?php
$showError = displayError($error, 'year');
echo $showError;
?>
<label>publication dat:</label>
<input type="text" name="year" placeholder="year">
</div>

<div>
  <?php
  $showError = displayError($error, 'category');
  echo $showError;
  ?>
<label>categories:</label>
<select name="category">
<option value="">Select Category</option>
<?php  $data = selectCategory($conn);
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
<?php
$showError = displayError($error, 'img');
echo $showError;
?>
<label>Image:</label>
<input type="file" name="img" placeholder="Image">
</div>


<input type="submit" name="submit" value="Add Book">
</form>

</div>











<?php

  include "include/footer.php";
 ?>
