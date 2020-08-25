<?php 
  include('scripts/php/connect.php');
  session_start();
  if (!isset($_SESSION['email'])) {
    header('location: login.php');
  }
  if(isset($_GET['user'])){
    $uid = $_GET['user'];
  }else{
    header('location: index.php');
  }
  $user_query = "SELECT firstName, lastName FROM users_tb WHERE uid = ".$_GET['user']."";
  $user_query_result = $conn->query($user_query);
  if($user_query_result){
    $user_details =  $user_query_result->fetch_assoc();
  }
  $num_post_result = $conn->query("SELECT COUNT(post_id) from post_tb WHERE uid = ".$uid."");
  $num_post_row = $num_post_result->fetch_assoc();
  $num_follers_result = $conn->query("SELECT COUNT(uid) from followers_tb WHERE fid = ".$uid."");
  $num_follers_row = $num_follers_result->fetch_assoc();
  $num_follings_result = $conn->query("SELECT COUNT(fid) from followers_tb WHERE uid = ".$uid."");
  $num_follings_row = $num_follings_result->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
  <title>PROFILE</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/android-icon-192x192.png">
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/apple-icon-180x180.png">
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/ms-icon-310x310.png">
  <link rel="stylesheet" href='https://use.fontawesome.com/releases/v5.4.1/css/all.css' integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz' crossorigin='anonymous' />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/modal.css">
  <link rel="stylesheet" href="css/profile.css">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark nav-border">
    <div class="container">
      <a class="navbar-brand" href="#">BitHub</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-toggled="collapsed" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="nav navbar-nav mr-auto">

        </ul>
        <ul class="nav navbar-nav ml-auto">

          <?php if($uid == $_SESSION['uid']){ ?>
          <li class="nav-item hover" data-toggle="modal" data-target="#myModal">
            <a class="nav-link" href="#">
              <i class="fas">&#xf067;</i>
              <span>&nbsp;Add Post</span>
            </a>
          </li>
          <?php  }?>

          <li class="nav-item hover">
            <a class="nav-link" href="dashboard.php">
              <i class="fas">&#xf015;</i>
              <span>&nbsp;Home</span>
            </a>
          </li>
          <li class="nav-item hover 
             <?php
                if($uid == $_SESSION['uid']){
                  echo("active");
                }
             ?>">
            <a class="nav-link" href="
              <?php 
                if($uid != $_SESSION['uid']){
                  echo(" profile.php?user=".$_SESSION['uid']);
                }else{
                  echo " #"; } ?>
              ">
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
            <input type="hidden" name="from" value="profile.php?user=<?php echo $uid; ?>">
            <button type="submit" class="btn btn-block btn-dark" name="upload">Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="container">
        <div class="col-md-12">
          <div class="d-md-flex profile-info">
            <div class="img-holder mx-auto">
              <img src="img/img_avatar1.png" alt="USER IMAGE" class="d-block mx-auto rounded-circle">
            </div>
            <div class="flex-grow-1 p-2">
              <div class="d-flex flex-column p-2 justify-content-center align-items-center">

                <div class="username p-2">
                  <span>
                    <?php echo $user_details['firstName'] ?>&nbsp;&nbsp;</span>
                  <span>
                    <?php echo $user_details['lastName'] ?></span>
                </div>
                <div class="stats d-flex">
                  <div class="d-flex p-2 flex-column posts">
                    <div class="numposts text-center">
                      <span>
                        <?php echo $num_post_row['COUNT(post_id)']; ?></span>
                    </div>
                    <div class="spanposts">
                      <span>Posts</span>
                    </div>
                  </div>
                  <div class="d-flex p-2 flex-column followers">
                    <div class="numfollowers text-center">
                      <span>
                        <?php echo $num_follers_row['COUNT(uid)']; ?></span>
                    </div>
                    <div class="spanfollowers">
                      <span>Followers</span>
                    </div>
                  </div>
                  <div class="d-flex p-2 flex-column following">
                    <div class="numfollowing text-center">
                      <span>
                        <?php echo $num_follings_row['COUNT(fid)']; ?></span>
                    </div>
                    <div class="spanfollowing">
                      <span>Following</span>
                    </div>
                  </div>
                </div>
                <?php 
                  if($uid != $_SESSION['uid']){ 
                    $folq_res = $conn->query("SELECT uid FROM followers_tb WHERE fid = ".$uid." AND uid = ".$_SESSION['uid']."");
                    if($folq_res->num_rows > 0){
                      $set = 'followed';
                    }else{
                      $set = 'follow';
                    }
                ?>
                <div class="p-2 align-self-center">
                  <button id="follow<?php echo $uid  ?>" data-fol="<?php echo $set ?>" type="button" class="btn follow-btn btn-outline-light follow"></button>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 content">
        <div class="container">
          <legend>Search within the documents:</legend>
          <input class="form-control search-input" id="myInput" type="text" placeholder="Search.."><br>
          <div class="row">
            <?php 
                $sql = "SELECT `post_id`, `post_title`, `post_des` FROM `post_tb` WHERE uid=".$uid." ORDER BY post_systime DESC";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                  while($row = $result->fetch_assoc()){
                    $numlikes = "SELECT COUNT(userid) from like_tb WHERE postid = ".$row['post_id']."";
                    $nlikesres = $conn->query($numlikes);
                    $nlikesrow = $nlikesres->fetch_assoc();
                    $numcomms = "SELECT COUNT(comment_id) from comment_tb WHERE post_id = ".$row['post_id']."";
                    $ncommsres = $conn->query($numcomms);
                    $ncommsrow = $ncommsres->fetch_assoc();
                    echo('<div id="post'.$row['post_id'].'" class="col-md-4 post-holder">');
                      echo('<div class="card post text-dark">');
                        echo('<div class="card-body">');
                          echo('<a href="post.php?postkey='.$row['post_id'].'">');
                            echo('<h4 class="card-title text-center">'.$row['post_title'].'</h4>');
                          echo('</a>');
                          echo('<div class="post-descriptor">');
                            if(strlen($row['post_des']) > 100){
                              echo('<p>'.substr($row['post_des'], 0, 100).'...&nbsp;<a href="post.php?postkey='.$row['post_id'].'"><u>Read More</u></a></p>');
                            }else{
                              echo('<p>'.$row['post_des'].'</p>');
                            }
                          echo('</div>');
                          echo('<div class="social d-flex justify-content-end">');
                            echo('<div class="likes d-flex">');
                              echo('<span>'.$nlikesrow['COUNT(userid)'].'</span>');
                              echo('<a href="post.php?postkey='.$row['post_id'].'"><button id="like'.$row['post_id'].'" class="float-right post-btn like"><i class="far">&#xf164;</i></button></a>');
                            echo('</div>');
                            echo('<div class="comment d-flex">');
                              echo('<span>'.$ncommsrow['COUNT(comment_id)'].'</span>');
                              echo('<a href="post.php?postkey='.$row['post_id'].'"><button id="comm'.$row['post_id'].'" class="float-right post-btn toggle-comment" data-toggId="'.$row['post_id'].'"><i class="far">&#xf075;</i></button></a>');
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
        </div>
      </div>
      <div class="col-md-2 text-center">
        <!-- <h4>SORT BY</h4> -->
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="scripts/js/profile.js"></script>
</body>

</html>
