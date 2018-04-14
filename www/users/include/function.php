<?php

function uploadFile($file, $nam, $uploades){

  $result = [];

  $ran =rand(0000000000, 999999999);
  $strip_name = str_replace(' ', '_', $file[$nam]['name']);
  $filename =$ran.$strip_name;
  $destination = $uploades.$filename;

  if(move_uploaded_file ($file[$nam]['tmp_name'], $destination)){

    $result[] = true;
    $result[]= $destination;
  }else{
    $result= false;
  }
return $result;
}

function userRegister($dbcon, $input){
        $hash = password_hash($input['hash'], PASSWORD_BCRYPT);

      $stat = $dbcon -> prepare("INSERT INTO user (firstname, lastname, email, username, hash)
                                  VALUES(:fn, :ln, :e, :us, :h)");

                  $data = [
                    ':fn' => $input['fname'],
                    ':ln' => $input['lname'],
                    ':e' => $input['email'],
                    ':us' => $input['username'],
                    ':h' => $hash
                  ];

              $stat->execute ($data);
}

function doesEmailExist($dbconn, $email){
  $result = false;

  $stat = $dbconn -> prepare("SELECT email from user WHERE :e=email");

  $stat-> bindparam(':e', $email);

  $stat -> execute();

  $count = $stat -> rowCount();
  if ($count > 0){
    $result = true;
  }
  return $result;
}

function displayError($err, $name){
  $result= "";
    if (isset($err[$name])){
      $result = '<p class="form-error">'.$err[$name].'</p>';
     

    }
return $result;
}

function userlogin($dbcon, $data){
    $result = [];
  $stat = $dbcon ->prepare ("SELECT * FROM user WHERE :e=email");


  $stat ->bindparam(':e', $data['email']);
  //$stat ->bindparam(':h', $v['password']);

  $stat ->execute();
    $user= $stat->fetch(PDO::FETCH_ASSOC);
    if($stat -> rowCount() !== 1 || !password_verify($data['hash'], $user['hash'])){

      $result[] = false;


  }else{
    $result[] = true;
    $result [] = $user;
  }
  return $result;

}
function authentication($authenticate){
  if(!isset($authenticate['admin_id']) || !isset($authenticate['firstname']) || !isset($authenticate['lastname']) || !isset($authenticate['email'])){
    $err="please, Login valid details";
    header("location:admin_login.php?error=$err");
  }


}
//LAST CLASS
//here is the function for add category page.
function addCategory($dbcon, $data){
  $stat = $dbcon ->prepare ("INSERT INTO add_category(category_name, date_created) VALUE (:name, NOW())");
  $stat ->bindParam(':name', $data['category_name']);
  $stat ->execute();
  echo "Successful";
}
//here is the function for view category page.
function viewCategories($dbcon){
 $result ="";
  $stat = $dbcon -> prepare("SELECT * FROM add_category");
  $stat ->execute();

  while($row = $stat -> fetch(PDO::FETCH_BOTH)){

    $result .= "<tr><td>".$row['category_id']."</td>";
    $result .= "<td>".$row['category_name']."</td>";
    $result .= "<td>".$row['date_created']."</td>";
    $result .= '<td><a href=edit_category.php?cat_id='.$row[0].'>edit</a></td>';
    $result .= '<td><a href=delete_category.php?cat_id='.$row[0].'>delete</a></td></tr>';

  }
  return $result;
}
//function edit category is used for editing category name.
function editCategory($dbcon, $data, $dat){
  $stat= $dbcon->prepare("UPDATE add_category SET category_name=:e, date_created=NOW() WHERE category_id=:id");
  $stat->bindParam(':e', $data['category_name']);
  $stat->bindParam(':id', $dat);
  $stat ->execute();
  header("Location:view.php");

}
//function delete category is use to delete categories from page view category.
function deleteCategory($dbcon, $data){
  $stat= $dbcon->prepare("DELETE  FROM add_category  WHERE category_id=:id");
  $stat->bindParam(':id', $data);
  $stat ->execute();
  header("Location:view.php");

}
function getcategorybyid($dbcon, $id){
  $result = "";
  $stat = $dbcon -> prepare("SELECT * FROM add_category WHERE category_id=:cat_id");
  $stat ->bindParam(':cat_id', $id);
  $stat ->execute();
  $result = $stat -> fetch (PDO::FETCH_BOTH);


    return $result;
}

function selectCategory($dbcon){
  $result = "";
  $stat = $dbcon ->prepare ("SELECT * FROM add_category");
  $stat -> execute();
  while($row = $stat ->fetch(PDO::FETCH_BOTH)){
    $result .= '<a href=catalogue.php?cat_id='.$row[0].'><li class="category">'.$row[1].'</li></a>';
    
  }
  return $result;
}
function addBooks($dbcon, $input){
  $stat = $dbcon->prepare("INSERT INTO add_books(title, author, price, category, flag, img_path, pub_date)
                          VALUES(:t, :a, :p, :c, :f, :im, :pub)");
                          $data = [
                            ':t'=> $input['title'],
                            ':a' => $input['author'],
                            ':p' => $input['price'],
                            ':c' => $input['category'],
                            ':f' => $input['flag'],
                            ':im' => $input['dest'],
                            ':pub' => $input['year'],
                          ];
                          $stat -> execute($data);
}
function getBookByCategory($dbcon, $catId){
  $result = "";
  $stat = $dbcon -> prepare("SELECT * FROM add_books WHERE category =:cat_id");
  $stat ->bindParam(':cat_id', $catId);
  $stat ->execute();
    while($row = $stat -> fetch (PDO::FETCH_BOTH)){

     $result .= '<li class="book">
      <a href="#"><div class="book-cover" style="background-image:url('.$row['img_path'].'); background-size:cover; background-position:center; background-repeat: no-repeat;"></div>';
      $result .= '<div class="book-price"><p>'.$row['price'].'</p></div>
        </li>';
    }


    return $result;
}
function viewBooks($dbcon){
 $result ="";
  $stat = $dbcon -> prepare("SELECT * FROM add_books");
  $stat ->execute();

  while($row = $stat -> fetch(PDO::FETCH_BOTH)){

    $result .= "<tr><td>".$row['book_id']."</td>";
    $result .= "<td>".$row['title']."</td>";
    $result .= "<td>".$row['author']."</td>";
    $result .= "<td>".$row['price']."</td>";
    $result .= "<td>".$row['category']."</td>";
    $result .= "<td>".$row['flag']."</td>";
    $result .= "<td>"."<div style=\"width:50px; height:50px; background-image:url('".$row['img_path']."'); background-size:cover;background-repeat:no-repeat;background-position:center\"></div></td>";
    $result .= "<td>".$row['pub_date']."</td>";
    $result .= '<td><a href=edit_books.php?book_id='.$row[0].'>edit</a></td>';
    $result .= '<td><a href=delete_books.php?book_id='.$row[0].'>delete</a></td></tr>';

  }
  return $result;
}

function editBooks($dbcon, $bookId, $input){
  $stat= $dbcon->prepare("UPDATE add_books SET title=:t, author=:a, price=:p, category=:c, flag=:f,
                           pub_date=:pub WHERE book_id=:bi");

  $input= [
    ':bi'=> $bookId,
    ':t'=> $input['title'],
    ':a' => $input['author'],
    ':p' => $input['price'],
    ':c' => $input['category'],
    ':f' => $input['flag'],
    ':pub' => $input['year'],
  ];
  $stat ->execute($input);
  header("Location:view_books.php");

}

function deleteBook($dbcon, $data){
  $stat= $dbcon->prepare("DELETE  FROM add_books  WHERE book_id=:id");
  $stat->bindParam(':id', $data);
  $stat ->execute();
  header("Location:view_books.php");

}
function curNav($page){
  $curPage = basename($_SERVER['SCRIPT_NAME']);
  if($page === $curPage){
    echo 'class="selected"';
  }

}


function editBookImage($dbcon, $bookId, $input){
  $stat= $dbcon->prepare("UPDATE add_books SET img_path=:img WHERE book_id=:bi");

  $input= [
    ':bi'=> $bookId,
    ':img'=> $input
  ];
  $stat ->execute($input);
  header("Location:view_books.php");

}


function logout(){
  unset($_SESSION['admin_id']);
  unset($_SESSION['firstname']);
  unset($_SESSION['lastname']);
  unset($_SESSION['email']);
  $err= "logout Successful";
  header("Location:admin_login.php?error=$err");
}

?>
