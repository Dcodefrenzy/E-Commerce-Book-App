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


function viewComment($dbcon){
 $result ="";
  $stat = $dbcon -> prepare("SELECT * FROM comments");
  $stat ->execute();

  while($row = $stat -> fetch(PDO::FETCH_BOTH)){

          $result .= '<li class="review">
          <div class="avatar-def user-image">
            <h4 class="user-init"></h4>
          </div>
          <div class="info">';
            $result .= '<h4 class="username">'.$row['username'].'</h4>';
            $result .= '<p class="comment">'.$row['comment'].'</p>
          </div>
        </li>';
  }
  return $result;
}

function insertCartInfo($dbcon, $input, $userId){
  $stat = $dbcon->prepare("INSERT INTO cart(item_name, item, price, quantity, total, user_id)
                          VALUES(:itn, :it, :pr, :co, :to, :ui)");
                          $data = [
                            ':itn' => $input['book_name'],
                            ':it' => $input['img_path'],
                            ':pr' => $input['price'],
                            ':co'=> $input['amount'],
                            ':to' => $input['total'],
                            ':ui' => $userId,
                          ];
                          $stat -> execute($data);

}

function viewCartInfo($dbcon, $userId){
 $result ="";
  $stat = $dbcon -> prepare("SELECT * FROM cart WHERE user_id = :ui");
  $stat-> bindParam(':ui', $userId);
  $stat ->execute();
  

  while($row = $stat -> fetch(PDO::FETCH_BOTH)){

            $result.='<tr>';
          $result .= '<td><div class="book-cover" style="background: url('.$row['item'].'); background-size: cover;
          background-position: center; background-repeat: no-repeat" ;></div></td>';
          $result .= '<td><p class="book-price">'.$row['price'].'</p></td>';
          $result .='<td><p class="quantity">'.$row['quantity'].'</p></td>';
          $result .= '<td><p class="total">'.$row['total'].'</p></td>
          <td>
            <form class="update" method="POST">
              <input type="number" class="text-field qty" name="edit">
              <input type="submit" class="def-button change-qty"  name="submit" value="Change Qty">
            </form>
          </td>
          <td>
            <a href="cart_delete.php?cart_id='.$row['cart_id'].'" class="def-button remove-item">Remove Item</a>
          </td>
        </tr>';


  }
  return $result;
}

function viewCartInfoForUpdate($dbcon, $userId){
 $result =[];
  $stat = $dbcon -> prepare("SELECT * FROM cart WHERE user_id = :ui");
  $stat-> bindParam(':ui', $userId);
  $stat ->execute();

  $result = $stat -> fetch(PDO::FETCH_BOTH);
      



  return $result;
}

function updateCartQuantity($dbcon, $input, $userId){
  $stat= $dbcon->prepare("UPDATE cart SET quantity=:e WHERE user_id =:id && cart_id = :ca");
  $data = [':e' => $input['edit'],
            ':ca' => $input['cart_id'],
            ':id' => $userId,
            
          ];
  $stat ->execute($data);

}

function deleteCart($dbcon, $input){
  $stat= $dbcon->prepare("DELETE  FROM cart  WHERE cart_id=:id");
  $stat->bindParam(':id', $input);
  $stat ->execute();
 

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

function insertComment($dbcon, $input, $userId, $userName){
  $stat = $dbcon->prepare("INSERT INTO comments(comment, user_id, username, date_created)
                          VALUES(:co, :us, :usn, NOW())");
                          $data = [
                            ':co'=> $input['comment'],
                            ':us'=> $userId,
                            ':usn'=> $userName,
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
      <a href="book_preview.php?book_id='.$row['book_id'].'"><div class="book-cover" style="background-image:url('.$row['img_path'].'); background-size:cover; background-position:center; background-repeat: no-repeat;"></div>';
      $result .= '<div class="book-price"><p>'.$row['price'].'</p></div>
        </li>';
    }


    return $result;
}
function getBooksByBookId($dbcon, $bookId){
 $result ="";
  $stat = $dbcon -> prepare("SELECT * FROM add_books WHERE book_id = :bi");
  $stat ->bindParam(':bi', $bookId);
  $stat ->execute();

  if ($row = $stat -> fetch(PDO::FETCH_BOTH)){
      $result .= '<div class="display-book" style="background: url('.$row['img_path'].'); background-size: cover;
  background-position: center; background-repeat: no-repeat";></div>';
      $result .=  '<div class="info">';
      $result .= '<h2 class="book-title">'.$row['title']. '</h2>';
       $result .= '<h3 class="book-author">'.$row['author'].'</h3>';
       $result .= '<h3 class="book-price">'.$row['price'].'</h3>';

  }
  return $result;
}
    function getBooksByBookIdForCart($dbcon, $bookId){
  $result =array ();
  $stat = $dbcon -> prepare("SELECT * FROM add_books WHERE book_id = :bi");
  $stat ->bindParam(':bi', $bookId);
  $stat ->execute();

   $result = $stat -> fetch(PDO::FETCH_BOTH);

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
