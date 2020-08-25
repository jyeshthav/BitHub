<?php
  if(!isset($_SESSION)){ 
      session_start(); 
  }
  if (!isset($_SESSION['email'])) {
    header('location: login.php');
  }
  include('scripts/php/connect.php');
  
?>


<!DOCTYPE html>
<html>

<head>
  <title>POST</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/ms-icon-310x310.png">
  <link rel="stylesheet" href='https://use.fontawesome.com/releases/v5.4.1/css/all.css' integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz' crossorigin='anonymous' />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/post.css">
</head>

<?php 
  
  $doc_res = $conn->query("SELECT  users_tb.firstName, users_tb.lastName, post_tb.post_id, post_tb.uid, post_tb.post_title, post_tb.post_des, post_tb.post_systime, post_tb.post_UTCtime FROM `users_tb`, `post_tb` WHERE post_tb.uid = users_tb.uid AND post_tb.post_id = ".$_GET['postkey']."");
  if($doc_res->num_rows > 0){
    $doc_row =$doc_res->fetch_assoc();
    $file_res = $conn->query("SELECT `doc_id`, `doc_name`, `doc_path` FROM `doc_tb` WHERE doc_postid = ".$doc_row['post_id']."");
  }else{
    header('location: dashboard.php');
  }
  
?>

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
        <li class="nav-item hover">
          <a class="nav-link" href="dashboard.php">
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
  <div class="container">
    <div class="container">
      <div class="row post">
        <div class="col-md-4 user-stuff">
          <div class="d-flex flex-column p-2">
            <div class="img-holder">
              <img src="img/img_avatar1.png" alt="User image" class="d-block mx-auto rounded-circle">
            </div>
            <div class="user-details d-flex flex-column text-center">
              <div class="username">
                <h4>
                  <span><?php echo $doc_row['firstName'] ?>&nbsp;</span>
                  <span><?php echo $doc_row['lastName'] ?></span>
                </h4>
              </div>
              <div class="post-time">
                <span>Posted on:</span>
                <span><em><?php echo $doc_row['post_systime'] ?></em></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8 post-content p-3">
          <div class="post-title">
            <h4><?php echo $doc_row['post_title'] ?></h4>
          </div>
          <div class="post-des p-2 text-justify">
            <p>
              <?php echo $doc_row['post_des'] ?>
            </p>
          </div>
          <div class="list-group files">
            <?php 
              if($file_res->num_rows > 0){
                while($file_row = $file_res->fetch_assoc()){
                  echo('<a id="file'.$file_row['doc_id'].'" href="'.str_replace("../../","",$file_row['doc_path']).'" class="list-group-item list-group-item-action">'.$file_row['doc_name'].'</a>');
                }
              }
            ?>
          </div>
          <?php
            $liked = "SELECT userid from like_tb WHERE userid = ".$_SESSION['uid']." AND postid = ".$_GET['postkey']."";
            $numlikes = "SELECT COUNT(userid) from like_tb WHERE postid = ".$_GET['postkey']."";
            $nlikesres = $conn->query($numlikes);
            $nlikesrow = $nlikesres->fetch_assoc();
            $likedres = $conn->query($liked);
            $commsql = "SELECT comment_tb.comment_id, comment_tb.comment_time, comment_tb.comment_text, users_tb.firstName, users_tb.lastName FROM `comment_tb`,`users_tb` WHERE comment_tb.post_id = ".$_GET['postkey']." and users_tb.uid = comment_tb.uid ORDER BY comment_tb.comment_time DESC";
            $commres = $conn->query($commsql);
            if($likedres->num_rows > 0){
              $set = 1;
            }else{
              $set = 0;
            }
          ?>
          <div class="social d-flex justify-content-end">
            <div class="likes d-flex">
              <span><?php echo $nlikesrow['COUNT(userid)'] ?></span>
              <button id="like<?php echo $_GET['postkey'] ?>" class="float-right post-btn like" data-user="<?php echo $_SESSION['uid'] ?>" data-liked="<?php echo $set ?>"><i class="far">&#xf164;</i></button>
            </div>
            <div class="comment d-flex">
              <span><?php echo $commres->num_rows ?></span>
              <button id="comm<?php echo $_GET['postkey'] ?>" class="float-right post-btn toggle-comment" data-toggId="<?php echo $row['post_id'] ?>"><i class="far">&#xf075;</i></button>
            </div>
          </div>
        </div>
        <div id="comment-box<?php echo $_GET['postkey'] ?>" class="col-lg-12 comment-box">
          <div class="d-flex">
            <div class="ipfield flex-grow-1 mr-2">
              <input id="comment-input<?php echo $_GET['postkey'] ?>" type="text" class="form-control comment-input">
            </div>
            <button id="post-comment<?php echo $_GET['postkey'] ?>" class="btn btn-primary flex-shrink-1 post-comment">Post</button>
          </div>
          <div id="all-comments<?php echo $_GET['postkey'] ?>" class="all-comments mt-3">
            <span>Comments:</span>
            <div class="comments">
              <div id="comment-holder<?php echo $_GET['postkey'] ?>" class="comment-holder" class="media p-2">
                <?php 
                  if($commres->num_rows > 0){
                    while($commrow = $commres->fetch_assoc()){ 
                ?>
                  <div id="comment-id<?php echo $commrow['comment_id'] ?>" class="media-body">
                    <h4><span><?php echo $commrow['firstName'] ?>&nbsp;&nbsp;</span><span><?php echo $commrow['lastName'] ?>&nbsp;&nbsp;</span><small><i></i><em><span>Posted at <?php echo $commrow['comment_time'] ?></span></em></small></h4>
                    <p><?php echo $commrow['comment_text'] ?></p>
                  </div>
                <?php 
                    }  
                  }else{
                    echo("<span><i>Be the first to comment</i></span>");
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="scripts/js/post.js"></script>
</body>

</html>
