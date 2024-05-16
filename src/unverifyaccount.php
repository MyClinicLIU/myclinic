<?php

    session_start();

    if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Admin"){
      header("Location: index.php");
    }

    include_once "dbconnect.php";

    $id = $_GET["id"];
    mysqli_query($conn, "UPDATE users SET verified = '0' WHERE id = ".$id);

    header("Location: verifyusers.php");

?>
