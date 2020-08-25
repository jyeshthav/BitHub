<?php
  session_start();
  $_SESSION['regtrue'] = false;
  if(isset($_SESSION['regerrors'])){
    unset($_SESSION['regerrors']);
  }
  if(isset($_SESSION['loginerrors'])){
    unset($_SESSION['loginerrors']);
  }
  $_SESSION['regerrors'] = array();
  include("connect.php");
  $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  
  $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
  $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $password = filter_var($password, FILTER_SANITIZE_STRING);

  if (empty($firstName)) { 
    array_push($_SESSION['regerrors'], "firstName is required"); 
  }
  if (empty($lastName)) { 
    array_push($_SESSION['regerrors'], "lastName is required"); 
  }
  if (empty($email)) { 
    array_push($_SESSION['regerrors'], "email is required"); 
  }
  if (empty($password)) {
    array_push($_SESSION['regerrors'], "password is required"); 
  }
  
  $user_check_query = "SELECT * FROM users_tb WHERE email='$email'";
  $user_check_result = $conn->query($user_check_query);
  if($user_check_result->num_rows > 0){
    array_push($_SESSION['regerrors'], "email already exists");
  }
  
  if (count($_SESSION['regerrors']) == 0) {
  	
    
    $new_user = "INSERT INTO `users_tb`(`firstName`, `lastName`, `email`, `password`) VALUES (?, ?, ?, ?)";
    $new_user_stmt = $conn->prepare($new_user);
    $new_user_stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
  	$new_user_stmt->execute();
    if($new_user_stmt){
      unset($_SESSION['regerrors']);
      $_SESSION['email'] = $email;
      $_SESSION['firstName'] = $firstName;
      $_SESSION['lastName'] = $lastName;
      $_SESSION['uid'] = $conn->insert_id;
      $_SESSION['regtrue'] = true;
      mkdir('../../uploads/'.$_SESSION['email'].'/');
      header('location: ../../dashboard.php');    
    }
  }else{
    header('location: ../../register.php');
  }
?>