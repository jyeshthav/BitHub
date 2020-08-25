<?php
  include('connect.php');
  session_start();
  if($_POST['type'] == "follow"){
    $rdata = array("return"=>"false", "numfollers" => $_POST['numfollers']);
    $query = "INSERT INTO followers_tb VALUES(?, ?)";
    $stmt = $conn->prepare($query);
    $rdata["numfollers"] = filter_var($rdata["numfollers"]);
    $fid = filter_var($_POST['fid'], FILTER_SANITIZE_STRING);
    $stmt->bind_param("ss", $_SESSION['uid'], $fid);
    $stmt->execute();
    if($stmt){
      $sql = "SELECT COUNT(uid) from followers_tb WHERE fid = ".$fid."";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $rdata["return"] = true;
        $rdata["numfollers"] = $row['COUNT(uid)'];
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
  else if($_POST['type'] == "followed"){
    $rdata = array("return"=>"false", "numfollers" => $_POST['numfollers']);
    $rdata["numfollers"] = filter_var($rdata["numfollers"]);
    $fid = filter_var($_POST['fid'], FILTER_SANITIZE_STRING);
    $query = "DELETE FROM `followers_tb` WHERE uid = ".$_SESSION['uid']." AND fid = ".$fid."";
    $stmt = $conn->query($query);
    if($stmt){
      $sql = "SELECT COUNT(uid) from followers_tb WHERE fid = ".$fid."";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $rdata["return"] = true;
        $rdata["numfollers"] = $row['COUNT(uid)'];
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