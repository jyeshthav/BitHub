<?php
  session_start();
  include('scripts/php/connect.php');
//  include('scripts/php/server.php');
  if(isset($_SESSION['uid'])){ 
    header('location:dashboard.php');
  }
  if(isset($_SESSION['loginerrors'])){
    unset($_SESSION['loginerrors']);
  }
?>
<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/ms-icon-310x310.png" />
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/android-icon-192x192.png" />
  <link rel="icon" href="img/e66fcbd90ca1a85b8aeb5fd7fe3afb94.ico/apple-icon-180x180.png" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" />
  <link rel="stylesheet" href="css/forms.css">
  <link rel="stylesheet" href="css/common.css">
</head>

<body>
  <div class="errors">
    <h4 class="cross">X</h4>
    <?php
      if(isset($_SESSION['regerrors'])){
        if(count($_SESSION['regerrors']) > 0){
        foreach ($_SESSION['regerrors'] as $error) {
          echo('<p>'.$error.'</p>'); 
          }
        }  
      }
    ?>  
  </div>
  <div class="container text-center">
    <h2>Welcome to Bithub</h2>
    <img src="img/bithub_logo3.png" alt="Bithub" class="img-responsive mx-auto d-block logo-img">
    <div class="fields">
      <form action="scripts/php/reguser.php" method="POST">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Person</span>
          </div>
          <input type="text" class="form-control" placeholder="First Name" name="firstName">
          <input type="text" class="form-control" placeholder="Last Name" name="lastName">
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Your Email" name="email">
          <div class="input-group-append">
            <span class="input-group-text">@somaiya.edu</span>
          </div>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Password</span>
          </div>
          <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="reg_user">Register</button>
        <div class="linker">
          <span>Already a member?&nbsp;&nbsp;<a href="login.php">Login</a></span>
        </div>
      </form>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="scripts/js/common.js"></script>
</body>

</html>
