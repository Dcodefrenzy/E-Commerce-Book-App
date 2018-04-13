<?php
  include "function.php";
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    define("MAX_FILE_SIZE", 2097152);

    $ext = ['image/jpeg', 'image/jpg', 'image/png'];


    if(array_key_exists('submit', $_POST)){
        $error=array();
      if(empty($_FILES['image']['name'])){
        $error[]="Please Select an Image";
      }

      if($_FILES['image']['size'] > MAX_FILE_SIZE){
        $error[]= "Please the file exceed maximum";
      }

      if(!in_array($_FILES['image']['type'], $ext)){
        $error[]="Please The File type not supported";
      }




      if(empty($error)){

        uploadFile($_FILES, 'image', 'uploades/');

        echo "<p>File Upload Successful</p>";

      }else
      foreach($error as $error){
        echo "<p>* ".$error."</p>";
      }
    }



     ?>



    <form action="" method="POST" enctype="multipart/form-data">
      <p>Upload An Image</p>

      <input type="file" name="image">
      <input type="submit" name="submit">
    </form>

  </body>
</html>
