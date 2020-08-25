<?php
  session_start();
  include('connect.php');
  if($_POST['sortby'] == "sort-recent-foll"){
    $sql = "SELECT `users_tb`.`firstName`, `users_tb`.`lastName`,`post_tb`.`post_id`, `post_tb`.`uid`, `post_tb`.`post_title`, `post_tb`.`post_des`, `post_tb`.`post_systime`, `post_tb`.`post_UTCtime` FROM `post_tb`,`users_tb` WHERE `users_tb`.`uid` = `post_tb`.`uid` AND `post_tb`.`uid` IN (SELECT `followers_tb`.`fid` FROM `followers_tb` WHERE `followers_tb`.`uid` = ".$_SESSION['uid'].") ORDER BY post_systime DESC";  
  }
  elseif($_POST['sortby'] == "sort-recent-all"){
    $sql = "SELECT `users_tb`.`firstName`, `users_tb`.`lastName`,`post_tb`.`post_id`, `post_tb`.`uid`, `post_tb`.`post_title`, `post_tb`.`post_des`, `post_tb`.`post_systime`, `post_tb`.`post_UTCtime` FROM `post_tb`,`users_tb` WHERE `users_tb`.`uid` = `post_tb`.`uid` ORDER BY post_systime DESC";
  }
  elseif($_POST['sortby'] == "sort-likes"){
    $sql = "SELECT `users_tb`.`firstName`, `users_tb`.lastName, COUNT(userid),`post_tb`.`post_id`, `post_tb`.`uid`, `post_tb`.`post_title`, `post_tb`.`post_des`, `post_tb`.`post_systime`, `post_tb`.`post_UTCtime` FROM `users_tb`,`post_tb` LEFT JOIN `like_tb` ON `post_tb`.`post_id` = `like_tb`.`postid` WHERE `users_tb`.`uid` = `post_tb`.`uid` GROUP BY postid ORDER BY COUNT(userid) DESC";
  }
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $liked = "SELECT userid from like_tb WHERE userid = ".$_SESSION['uid']." AND postid = ".$row['post_id']."";
      $numlikes = "SELECT COUNT(userid) from like_tb WHERE postid = ".$row['post_id']."";
      $nlikesres = $conn->query($numlikes);
      $nlikesrow = $nlikesres->fetch_assoc();
      $likedres = $conn->query($liked);
      $postid = $row['post_id'];
      $sql2 = "SELECT `doc_id`, `doc_name`, `doc_path` FROM `doc_tb` WHERE doc_postid = $postid";
      $result2 = $conn->query($sql2);
      $commsql = "SELECT comment_tb.comment_id, comment_tb.comment_time, comment_tb.comment_text, users_tb.firstName, users_tb.lastName FROM `comment_tb`,`users_tb` WHERE comment_tb.post_id = ".$row['post_id']." and users_tb.uid = comment_tb.uid ORDER BY comment_tb.comment_time DESC";
      $commres = $conn->query($commsql);
      echo('<div class="container">');
        echo('<div id="post'.$row['post_id'].'" class="row post">');
          echo('<div class="col-lg-4 user-details text-center">');
            echo('<div class="img-holder">');
              echo('<img src="img/img_avatar1.png" alt="Bithub" class="user-img img-responsive rounded-circle">');
            echo('</div>');
            echo('<div class="user-info align-self-center">');
              echo('<h3><a href="profile.php?user='.$row['uid'].'"><span>'.$row['firstName'].'&nbsp;</span><span>'.$row['lastName'].'</span></a></h3>');
              echo('<h5>Posted at: <span>'.$row['post_systime'].'</span></h5>');
            echo('</div>');
          echo('</div>');
          echo('<div class="col-lg-8 post-details">');
            echo('<div class="post-title">');
              echo('<a href="post.php?postkey='.$row['post_id'].'">');
                echo('<h3>'.$row['post_title'].'</h3>');
              echo('</a>');
            echo('</div>');
            echo('<div class="post-des">');
              echo('<p>'.$row['post_des'].'</p>');
            echo('</div>');
            echo('<h4>Files:</h4>');
            echo('<div class="list-group files">');
              if($result2->num_rows > 0){
                while($row2 = $result2->fetch_assoc()){
                  echo('<a id="file'.$row2['doc_id'].'" href="'.str_replace("../../","",$row2['doc_path']).'" class="list-group-item list-group-item-action">'.$row2['doc_name'].'</a>');
                }
              }
            echo('</div>');
            if($likedres->num_rows > 0){
              $set = 1;
            }else{
              $set = 0;
            }
            echo('<div class="social d-flex justify-content-end">');
              echo('<div class="likes d-flex">');
                echo('<span>'.$nlikesrow['COUNT(userid)'].'</span>');
                echo('<button id="like'.$row['post_id'].'" class="float-right post-btn like" data-user="'.$_SESSION['uid'].'" data-liked="'.$set.'"><i class="far">&#xf164;</i></button>');
              echo('</div>');
              echo('<div class="comment d-flex">');
                echo('<span>'.$commres->num_rows.'</span>');
                echo('<button id="comm'.$row['post_id'].'" class="float-right post-btn toggle-comment" data-toggId="'.$row['post_id'].'"><i class="far">&#xf075;</i></button>');
              echo('</div>');
            echo('</div>');
          echo('</div>');
          echo('<div id="comment-box'.$row['post_id'].'" class="col-lg-12 comment-box">');
            echo('<div class="d-flex">');
              echo('<div class="ipfield flex-grow-1 mr-2">');
                echo('<input id="comment-input'.$row['post_id'].'" type="text" class="form-control comment-input">');
              echo('</div>');
              echo('<button id="post-comment'.$row['post_id'].'" class="btn btn-primary flex-shrink-1 post-comment">Post</button>');
            echo('</div>');
            echo('<div id="all-comments'.$row['post_id'].'" class="all-comments mt-3">');
              echo('<span>Comments:</span>');
              echo('<div class="comments">');
                echo('<div id="comment-holder'.$row['post_id'].'" class="comment-holder" class="media p-2">');
                  if($commres->num_rows > 0){
                    while($commrow = $commres->fetch_assoc()){
                      echo('<div id="comment-id'.$commrow['comment_id'].'" class="media-body">');
                        echo('<h4><span>'.$commrow['firstName'].'&nbsp;&nbsp</span><span>'.$commrow['lastName'].'&nbsp&nbsp</span><small><i></i><em><span>Posted at '.$commrow['comment_time'].'</span></em></small></h4>');
                        echo('<p>'.$commrow['comment_text'].'</p>');
                      echo('</div>');
                    }  
                  }else{
                    echo("<span><i>Be the first to comment</i></span>");
                  }
                echo('</div>');
              echo('</div>');
            echo('</div>');
          echo('</div>');
        echo('</div>');
      echo('</div>');
    }
  }else{
    echo('<h5><em>Click the &nbsp<i class="fas">&#xf067;</i>&nbsp to add your first post</em></h5>');
  }
?>