<?php
  session_start();
  include('connect.php');
  if($_POST['liked'] == 0){
    $rdata = array("return" => false, "numlikes" => $_POST['numlikes']);
    $sql1 = "INSERT INTO `like_tb`(`userid`, `postid`) VALUES (".$_SESSION['uid'].",".$_POST['postid'].")";
    $res1 = $conn->query($sql1);
    if($res1){
      $sql2 = "SELECT COUNT(userid) FROM like_tb WHERE postid = ".$_POST['postid']."";
      $res2 = $conn->query($sql2);
      if($res2->num_rows > 0){
        $rdata["return"] = true;
        while($row = $res2->fetch_assoc()){
          $rdata["numlikes"] = $row['COUNT(userid)'];
        }
        echo json_encode($rdata);
      }else{
        $rdata["return"] = false;   
      }
    }else{
      echo json_encode($rdata);  
    }
  }
  if($_POST['liked'] == 1){
    $rdata = array("return" => false, "numlikes" => $_POST['numlikes']);
    $sql1 = "DELETE FROM `like_tb` WHERE userid = ".$_SESSION['uid']." AND postid = ".$_POST['postid']."";
    $res1 = $conn->query($sql1);
    if($res1){
      $sql2 = "SELECT COUNT(userid) FROM like_tb WHERE postid = ".$_POST['postid']."";
      $res2 = $conn->query($sql2);
      if($res2->num_rows > 0){
        $rdata["return"] = true;
        while($row = $res2->fetch_assoc()){
          $rdata["numlikes"] = $row['COUNT(userid)'];
        }
        echo json_encode($rdata);
      }else{
        $rdata["return"] = false;
        echo json_encode($rdata);
      }
    }else{
      $rdata["return"] = false;
      echo json_encode($rdata);
    }
  }
?>