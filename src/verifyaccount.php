<?php

    session_start();

    if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Admin"){
      header("Location: index.php");
    }

    $conn = mysqli_connect('localhost','root','','myclinic') or die('connection failed');


    $id = $_GET["id"];
    mysqli_query($conn, "UPDATE users SET verified = '1' WHERE id = ".$id);

    header("Location: verifyusers.php");

?>