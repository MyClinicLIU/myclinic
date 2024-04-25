<?php

    session_start();

    if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Patient"){
      header("Location: index.php");
    }

    include_once "db_connection.php";

    $id = $_GET["id"];

    $meeting = mysqli_query($conn, "SELECT patient_id, doctor_id FROM meetings WHERE id = ".$id);

    $row = mysqli_fetch_assoc($meeting);
    $patient_id = $row["patient_id"];
    $doctor_id = $row["doctor_id"];

    mysqli_query($conn, "UPDATE meetings SET patient_id = null WHERE id = ".$id);

    $meeting = mysqli_query($conn, "SELECT id FROM meetings WHERE patient_id = '".$patient_id."' and doctor_id = '".$doctor_id."'");

    if(mysqli_num_rows($meeting) == 0){
      mysqli_query($conn, "DELETE FROM prescriptions WHERE patient_id = '".$patient_id."' and doctor_id = '".$doctor_id."'");
    }

    header("Location: appointments.php");

?>