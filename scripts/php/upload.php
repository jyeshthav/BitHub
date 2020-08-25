<?php
if(!isset($_SESSION)){ 
    session_start(); 
}
include('connect.php');
$uid = $_SESSION['uid'];
//$errors = array(); 
//include('errors.php');


if (isset($_POST['upload'])){
  $i = 0;
  $check = 0;
  $postTitle = filter_var($_POST['postTitle'], FILTER_SANITIZE_STRING);
  $postDesc = filter_var($_POST['postDesc'], FILTER_SANITIZE_STRING);
  $file_array = $_FILES['files']['name'];
  $file_size = $_FILES['files']['size'];
  $file_tmp = $_FILES['files']['tmp_name'];
  $target = array();
  $update = false;
  while($i < count($file_array)){

    $target_dir = "../../uploads/".$_SESSION['email']."/";
    $file_name = uniqid(basename($file_array[$i],".".pathinfo($file_array[$i],PATHINFO_EXTENSION)));
    $target_file = $target_dir.$file_name.".".pathinfo($file_array[$i],PATHINFO_EXTENSION);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    echo $target_dir." ".$file_name;
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "jpeg" && $fileType != "jpg" && $fileType != "docx" && $fileType != "ppt" && $fileType != "pptx" && $fileType != "png") {
//        array_push($errors,"Invalid file format for file: ".$file_array[$i]."");
        $uploadOk = 0;
    }

    if ($file_size[$i]> 8178893) {
//        array_push($errors,"Sorry, file: ".$file_array[$i]." is too large");
        $uploadOk = 0;
    }

  //          if (file_exists($target_file)) {
  //            array_push($errors,"Sorry, file ".$i." already exists");
  //            $uploadOk = 0;
  //          }

    if ($uploadOk == 0) {
//      array_push($errors,"Sorry, there was an error for file: ".$file_array[$i]."");
      break;
    }
    else{
      // if everything is ok, try to upload file
      if (move_uploaded_file($file_tmp[$i], $target_file)) {
          header('location: ../../'.$_POST['from'].'');
          $target[] = $target_file;
          $update = true;
      } 
      else {
//          array_push($errors,"Sorry, there was an error for file ".$file_array[$i]."");
          $update = false;
          break;
      }
    }
    $i++;
  } 
  $i = 0;
  if($update){
    $post_query = "INSERT INTO `post_tb`(`uid`, `post_title`, `post_des`, `post_systime`, `post_UTCtime`) VALUES (?,?,?,CURRENT_TIMESTAMP(),UTC_TIME())";
    $post_result = $conn->prepare($post_query);
    $post_result->bind_param("sss", $_SESSION['uid'], $postTitle, $postDesc);
    $post_result->execute();
    $pid = $conn->insert_id;
    if($post_result){
      while($i < count($file_array) && $update){    
        $file_query = "INSERT INTO doc_tb(doc_name, doc_path, doc_postid) VALUES (?, ?, ?)";
        $file_result = $conn->prepare($file_query);
        $file_result->bind_param("sss", $file_array[$i], $target[$i], $pid);
        $file_result->execute();
        if(file_result){
          $i++;    
        }else{
  //        array_push($errors,"Sorry, there was an error for file ".$file_array[$i]." and onwards");
          break;
        }
      }
    }
    else{
//      array_push($errors,"Sorry, there was an error for file ".$file_array[$i]." and onwards"); 
    }
  }else{
//      array_push($errors,"Sorry, there was some error in making the post");
  }
}

?>