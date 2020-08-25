<?php
session_start();

// initializing variables
$firstName = "";
$lastName = "";
$email = "";
$password = "";
$errors = array(); 

// connect to the database
include('connect.php');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstName)) { 
    array_push($errors, "firstName is required"); 
  }
  if (empty($lastName)) { 
    array_push($errors, "lastName is required"); 
  }
  if (empty($email)) { 
    array_push($errors, "email is required"); 
  }
  if (empty($password)) {
    array_push($errors, "password is required"); 
  }
    
  $user_check_query = "SELECT * FROM users_tb WHERE email='$email'";
  $user_check_result = $conn->query($user_check_query);
  if($user_check_result->num_rows > 0){
    array_push($errors, "email already exists");
  }
//  if ($user) { // if user exists
//    $user = mysqli_fetch_assoc($result);
//    if ($user['email'] === $email) {
//      
//    }
//  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	//$password = md5($password);//encrypt the password before saving in the database
    
    $new_user = "INSERT INTO `users_tb`(`firstName`, `lastName`, `email`, `pwd`) VALUES (?, ?, ?, ?)";
    $new_user_stmt = $conn->prepare($new_user);
    $new_user_stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
  	$new_user_stmt->execute();
  	
//    mysqli_query($conn, $query);  
//    $uid_query = "SELECT uid FROM users_tb WHERE email='$email' LIMIT 1";
//    $result2 = mysqli_query($conn, $uid_query);
//    $uid = mysqli_fetch_assoc($result2);
      
  	$_SESSION['email'] = $email;
  	$_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['uid'] = $conn->insert_id;
  	header('location: dashboard.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($email)) {
  	array_push($errors, "email is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	//$password = md5($password);
  	$query = "SELECT `uid`, `firstName`, `lastName`, `email` FROM `users_tb` WHERE email='$email' AND pwd='$password'";
  	$results = $conn->query($query);
  	if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        $_SESSION['email'] = $rows['email'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['uid'] = $rows['uid'];
        header('location: dashboard.php');
  	}else {
  		array_push($errors, "Wrong email/password combination");
  	}
  }
}

?>
