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
  $stat = $dbcon->prepare("INSERT INTO cart(item_name, item, price, quantity, user_id)
                          VALUES(:itn, :it, :pr, :co,  :ui)");
                          $data = [
                            ':itn' => $input['book_name'],
                            ':it' => $input['img_path'],
                            ':pr' => $input['price'],
                            ':co'=> $input['amount'],
                            ':ui' => $userId,
                          ];
                          $stat -> execute($data);

}

function viewCartInfo($dbcon, $userId, $start, $record){

  $stat = $dbcon -> prepare("SELECT * FROM cart WHERE user_id = :ui  order by cart_id DESC LIMIT $start, $record");
  $stat-> bindParam(':ui', $userId);
  $stat ->execute();
  return $stat;
}

function pagination($dbcon, $userId,  $record){
  $result = "";
  $stat = $dbcon -> prepare("SELECT * FROM cart WHERE user_id = :ui  ORDER BY cart_id DESC");
  $stat-> bindParam(':ui', $userId);
  $stat ->execute();
  $count = $stat->rowCount();
  $row = ceil($count/$record); 
      for($i=1; $i <= $row; $i++){ 
        
      $result .='<a href="cart.php?page='.$i.'"><p>'.$i.'</p></a>' ;
    }
  return $result;
}

function viewCartInfoForUpdate($dbcon, $cartId){
 
  $stat = $dbcon -> prepare("SELECT * FROM cart WHERE cart_id = :ui");
  $stat-> bindParam(':ui', $cartId);
  $stat ->execute();
  
      
  return $stat;
}

function getCartInfoForCheckout($dbcon, $userId){

  $stat = $dbcon -> prepare("SELECT * FROM cart WHERE user_id = :ui");
  $stat-> bindParam(':ui', $userId);
  $stat ->execute();
      
  return $stat;
}

function updateCartQuantity($dbcon, $input,  $userId, $cartId){
  $stat= $dbcon->prepare("UPDATE cart SET quantity=:e  WHERE user_id =:id && cart_id = :ca");
  $data = [':e' => $input['edit'],
            ':id' => $userId,
            ':ca' => $cartId,
            
          ];
  $stat ->execute($data);

}

function deleteCart($dbcon, $input){
  $stat= $dbcon->prepare("DELETE  FROM cart  WHERE cart_id=:id");
  $stat->bindParam(':id', $input);
  $stat ->execute();
 

}

function insertIntoCkeckout($dbcon, $input){
   $stat = $dbcon->prepare("INSERT INTO checkout(phonenumber, adress, postal_code, price, user_id)
                          VALUES(:pn, :ad, :po, :pr, :ui)");
                          $data = [
                            ':pn' => $input['phonenumber'],
                            ':ad' => $input['adress'],
                            ':po' => $input['post_code'],
                            ':pr' => $input['price'],
                            ':ui' => $input['user_id'],
                          ];
                          $stat -> execute($data);
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

  while($row = $stat -> fetch(PDO::FETCH_BOTH)){
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

function viewTrendingInfofromBooks($dbcon, $flag){
  $result= "";
  $stat = $dbcon->prepare("SELECT * FROM add_books WHERE flag =:fl");
  $stat->bindParam(':fl', $flag);
  $stat->execute();
  while($row=$stat->fetch(PDO::FETCH_BOTH)){
      extract($row);
       $result .='<li class="book">';
          $result .='<a href="book_preview.php?book_id='.$book_id.'"><div class="book-cover" style="background-image:url('.$img_path.'); 
                                      background-size:cover; 
                                      background-position:center; 
                                      background-repeat: no-repeat"> </div></a>';
          $result .='<div class="book-price"><p>'.$price.'</p></div>
        </li>';
  }
  return $result;
}

function insertIntoRecentlyViewedBook($dbcon, $input, $bookId, $userId){
  $stat= $dbcon->prepare("INSERT INTO recently_viewed(price, img_path, book_id, user_id) 
                            VALUES(:p, :img, :bi, :ui) ");
      $data=[
            ':p' =>$input['price'],
            ':img'=>$input['img_path'],
            ':bi'=>$bookId,
            ':ui'=>$userId,
      ];
      $stat->execute($data);
}
function getFromRecentlyViewedBook($dbcon, $bookId, $userId){
        $result="";
        $stat=$dbcon->prepare("SELECT * FROM recently_viewed WHERE book_id= :bi && user_id = :ui");
        $stat->bindParam(':bi', $bookId);
        $stat->bindParam(':ui', $userId);
        $stat->execute();
        $result=$stat->fetch(PDO::FETCH_ASSOC);
          
return $result;
}
function showRecentlyViewedBook($dbcon, $userId){
    $result="";
        $stat=$dbcon->prepare("SELECT * FROM recently_viewed WHERE  user_id = :ui LIMIT  4");
        $stat->bindParam(':ui', $userId);
        $stat->execute();
        while($row=$stat->fetch(PDO::FETCH_ASSOC)){
          extract($row);
        $result .='<div class="scroll-back"></div>
                  <div class="scroll-front"></div>';
          $result .= '<li class="book">';
          $result .= '<a href="book_preview.php?book_id='.$book_id.'">
                      <div class="book-cover" style="background-image:url('.$img_path.'); 
                                      background-size:cover; 
                                      background-position:center; 
                                      background-repeat: no-repeat"></div></a>';
          $result .='<div class="book-price"><p>'.$price.'</p></div>
        </li>';
        }
          
return $result;
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
