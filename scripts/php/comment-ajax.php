<?php
  session_start();
  include('connect.php');
  if($_POST['type'] == "post" && $_POST['commtext'] != ""){
    $rdata = array("return" => false, "numcomms" => $_POST['numcomms']);
    $commtext = filter_var($_POST['commtext'], FILTER_SANITIZE_STRING);
    $sql1 = "INSERT INTO `comment_tb`(`post_id`, `uid`, `comment_text`, `comment_time`) VALUES (?,?,?,CURRENT_TIMESTAMP())";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("sss",$_POST['postid'],$_SESSION['uid'],$commtext);
    $stmt1->execute();
    if($stmt1){
      $sql2 = "SELECT COUNT(comment_id) FROM comment_tb WHERE post_id = ".$_POST['postid']."";
      $res2 = $conn->query($sql2);
      if($res2->num_rows > 0){
        $rdata["return"] = true;
        while($row = $res2->fetch_assoc()){
          $rdata["numcomms"] = $row['COUNT(comment_id)'];
        }
      }else{
        $rdata["return"] = false;
      }
    }else{
      $rdata["return"] = false;
    }
    echo json_encode($rdata);
  }
  if($_POST['type'] == "load"){
    $commsql = "SELECT comment_tb.comment_id, comment_tb.comment_time, comment_tb.comment_text, users_tb.firstName, users_tb.lastName FROM `comment_tb`,`users_tb` WHERE comment_tb.post_id = ".$_POST['postid']." and users_tb.uid = comment_tb.uid ORDER BY comment_tb.comment_time DESC";
    $commres = $conn->query($commsql);
    if($commres){
      while($commrow = $commres->fetch_assoc()){
        echo('<div id="comment-id'.$commrow['comment_id'].'" class="media-body">');
          echo('<h4><span>'.$commrow['firstName'].'&nbsp;&nbsp</span><span>'.$commrow['lastName'].'&nbsp&nbsp</span><small><i></i><em><span>Posted at '.$commrow['comment_time'].'</span></em></small></h4>');
          echo('<p>'.$commrow['comment_text'].'</p>');
        echo('</div>');
      }  
    }
  }
?>