<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    session_start();
      include "include/db.php";
      include "include/nav.php";
      include "include/function.php";


      authentication($_SESSION);
      $id = $_GET['cat_id'];
    deleteCategory($conn,  $id);
    ?>

  </body>
</html>
