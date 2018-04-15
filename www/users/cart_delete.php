<?php 
include "include/db.php";
include "include/function.php";
//include "include/header2.php";

session_start();
$_SESSION['user_id'];

if(isset($_GET['cart_id'])){
	$cart_id = $_GET['cart_id'];
}
deleteCart($conn, $cart_id);
header("Location:cart.php");


 ?>