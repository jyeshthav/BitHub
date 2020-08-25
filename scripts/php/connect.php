<?php  
  $conn = new mysqli('localhost', 'root', '', 'bithub');
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
?>
