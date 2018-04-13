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



 ?>
 <?php   authentication($_SESSION);

 //Here we created a table so as to be able to view all our category name.?>

    <div class="wrapper">
      <div id="stream">
        <table id="tab">
          <thead>
            <tr>
              <th>post title</th>
              <th>post author</th>
              <th>date created</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
              <?php
              //here we called the function viewCategories from function.php file.
             $view = viewCategories($conn);
             echo $view;



               ?>
                </tbody>
        </table>
      </div>

      <div class="paginated">
        <a href="#">1</a>
        <a href="#">2</a>
        <span>3</span>
        <a href="#">2</a>
      </div>
    </div>
<?php include "include/footer.php"; ?>

  </body>
</html>
