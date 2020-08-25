<?php 
  include('scripts/php/upload.php');
  if(!isset($_SESSION)){ 
      session_start(); 
  }
  if (!isset($_SESSION['email'])) {
    header('location: login.php');
  }

  if (isset($_GET['logout'])) {
    session_destroy();
    header("location: login.php");
  }
  include('scripts/php/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/android-icon-192x192.png">
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/apple-icon-180x180.png">
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/ms-icon-310x310.png">
  <link rel="stylesheet" href='https://use.fontawesome.com/releases/v5.4.1/css/all.css' integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz' crossorigin='anonymous' />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/dash.css">
  <link rel="stylesheet" href="css/modal.css">
</head>

<body>

  <nav class="container navbar navbar-expand-md navbar-dark nav-border">
    <a class="navbar-brand" href="#">BitHub</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="nav navbar-nav mr-auto">

      </ul>
      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item hover" data-toggle="modal" data-target="#myModal">
          <a class="nav-link" href="#">
            <i class="fas">&#xf067;</i>
            <span>&nbsp;Add Post</span>
          </a>
        </li>
        <li class="nav-item hover active">
          <a class="nav-link" href="#">
            <i class="fas">&#xf015;</i>
            <span>&nbsp;Home</span>
          </a>
        </li>
        <li class="nav-item hover">
          <a class="nav-link" href="profile.php?user=<?php echo $_SESSION['uid'] ?>">
            <i class="fas">&#xf007;</i>
            <span>&nbsp;My Profile</span>
          </a>
        </li>
        <li class="nav-item hover">
          <a class="nav-link" href="dashboard.php?logout=\'1\'">
            <i class="fas">&#xf2f5;</i>
            <span>&nbsp;Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Upload new document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="scripts/php/upload.php" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-sm-3">Post name:</div>
              <div class="col-sm-9"><input type="text" name="postTitle" required /></div>
            </div>
            <div class="row">
              <div class="col-sm-3">Post description:</div>
              <div class="col-sm-9">
                <div class="form-group"><textarea class="form-control" rows="5" name="postDesc" required></textarea></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">File:</div>
              <div class="col-sm-9">
                <input type="file" name="files[]" multiple>
              </div>
            </div>
            <br>
            <input type="hidden" name="from" value="dashboard.php">
            <button type="submit" class="btn btn-block btn-dark" name="upload">Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container dash-body">
    <div class="row">
      <div class="col-md-9 all-posts">
        <?php
//          $sql2 = "SELECT users_tb.firstName users_tb.lastName, post_tb.post_id, post_tb.post_title, post_tb.post_des, post_tb.post_systime, post_tb.liked, post_tb.likes FROM `post_tb`,`users_tb` WHERE post_tb.uid = users_tb.uid";
          $sql = "SELECT `users_tb`.`firstName`, `users_tb`.`lastName`,`post_tb`.`post_id`, `post_tb`.`uid`, `post_tb`.`post_title`, `post_tb`.`post_des`, `post_tb`.`post_systime`, `post_tb`.`post_UTCtime` FROM `post_tb`,`users_tb` WHERE `users_tb`.`uid` = `post_tb`.`uid` AND `post_tb`.`uid` IN (SELECT `followers_tb`.`fid` FROM `followers_tb` WHERE `followers_tb`.`uid` = ".$_SESSION['uid'].") ORDER BY post_systime DESC";
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
      </div>
      <div class="col-md-3 d-flex flex-column p-5">
        <h4>SORT BY</h4>
        
        <div class="custom-control custom-radio  p-2">
          <input type="radio" class="custom-control-input sorting" id="sort-recent-foll" name="example1" checked="checked">
          <label class="custom-control-label" for="sort-recent-foll">Following</label>
        </div>
        <div class="custom-control custom-radio  p-2">
          <input type="radio" class="custom-control-input sorting" id="sort-recent-all" name="example1">
          <label class="custom-control-label" for="sort-recent-all">Recent posts</label>
        </div>
        <div class="custom-control custom-radio  p-2">
          <input type="radio" class="custom-control-input sorting" id="sort-likes" name="example1">
          <label class="custom-control-label" for="sort-likes">Top posts</label>
        </div>    
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="scripts/js/dashboard.social.js"></script>
</body>

</html>
