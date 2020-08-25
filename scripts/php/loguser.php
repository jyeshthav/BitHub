<?php
//  include('errors.php');
  session_start();
  $_SESSION['logintrue'] = false;
  if(isset($_SESSION['loginerrors'])){
    unset($_SESSION['loginerrors']);
  }
  if(isset($_SESSION['regerrors'])){
    unset($_SESSION['regerrors']);
  }
  $_SESSION['loginerrors'] = array();
  include('connect.php');

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  
  $email = filter_var($email,FILTER_SANITIZE_STRING);
  $password = filter_var($password,FILTER_SANITIZE_STRING);
  
  if (empty($email)) {
  	array_push($_SESSION['loginerrors'], "email is required");
  }
  if (empty($password)) {
  	array_push($_SESSION['loginerrors'], "Password is required");
  }

  if (count($_SESSION['loginerrors']) == 0) {
//  	$password = md5($password);
  	$query = "SELECT `uid`, `firstName`, `lastName`, `email` FROM `users_tb` WHERE email='$email' AND password='$password'";
  	$results = $conn->query($query);
  	if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        $_SESSION['email'] = $rows['email'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['uid'] = $rows['uid'];
        $_SESSION['logintrue'] = true;
        unset($_SESSION['loginerrors']);
        header('location: ../../dashboard.php');
  	}else {
  		array_push($_SESSION['loginerrors'], "Wrong email/password combination");
      header('location: ../../login.php');
  	}
  }else{
    header('location: ../../login.php');
  }

?>
