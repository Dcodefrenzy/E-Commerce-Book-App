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
      include "include/function.php";
      include "include/nav.php";



      authentication($_SESSION);
      $id = $_GET['book_id'];
      deleteBook($conn, $id);
    ?>

  </body>
</html>
