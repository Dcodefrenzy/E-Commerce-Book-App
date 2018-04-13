<?php
$page_title ="Add Books";
session_start();

  include "include/db.php";
  include "include/function.php";
  include "include/nav.php";




authentication($_SESSION);

$id = $_GET['book_id'];
$error = [];
$flag = ['Top selling', 'Trending', 'resently viewed' ];
define("MAX_FILE_SIZE", 2097152);
$ext = ['image/jpeg', 'image/jpg', 'image/png'];

if (array_key_exists('submit', $_POST)){

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

  $location = $info[1];
  }
  editBookImage($conn, $id, $location);
}
}





 ?>

<div class="wrapper">
<h1 id="register-label">Edit Book Image</h1>
<hr>
<form id="register" action ="" method ="POST" enctype="multipart/form-data">
 <div>
<?php
$showError = displayError($error, 'img');
echo $showError;
?>
<label>Image:</label>
<input type="file" name="img" placeholder="Image">
</div>

<input type="submit" name="submit" value="Edit Image">
</form>
</div>