<?php
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        header("location: login.php");
    }
?>