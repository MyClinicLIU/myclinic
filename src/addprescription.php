<?php

session_start();

if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Doctor"){
    header("Location: index.php");
 }

include_once "dbconnect.php";

$doctor_id = $_SESSION["id"];

$patients = mysqli_query($conn, "SELECT distinct u2.id, u2.name
                                FROM meetings m, users u1, users u2
                                WHERE m.doctor_id = u1.id and m.patient_id = u2.id and m.doctor_id = ".$doctor_id);

$medications = mysqli_query($conn, "SELECT id, name FROM medications ORDER BY name ASC");
$patients = mysqli_query($conn, "SELECT id, name FROM patients ORDER BY name ASC");
$checkups = mysqli_query($conn, "SELECT id, name FROM checkups ORDER BY name ASC");
function val($data){
   $data = trim($data); // Will trim the data, removes any unnecessary spaces
   $data = stripslashes($data); // Removes any unnecessary backslashes
   $data = htmlspecialchars($data); // Securing the data by using the htmlspecialchars function
   return $data;
}

$error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

   $success_message = "";

   $patient = val($_POST["patient"]);
   $medication = val($_POST["medication"]);
      $checkup = val($_POST["checkup"]);
	   $diago = val($_POST["diago"]);
   $pills = val($_POST["pills"]);
   $times = val($_POST["times"]);
$result = val($_POST["result"]);
   if(empty($pills)){
       $error_message .= "<li>Error: Pills is required!</li>";
   }
   if(empty($times)){
       $error_message .= "<li>Error: Times is required!</li>";
   }
   
   if($error_message == ""){

       $prescription = mysqli_query($conn, "SELECT id FROM prescriptions WHERE patient_id = '".$patient."' and medication_id = '".$medication."'");

      
            mysqli_query($conn, "INSERT into prescriptions (doctor_id, patient_id, medication_id,checkup_id,diagonist, pills, times,result) VALUES ('".$doctor_id."', '".$patient."', '".$medication."','".$checkup."','".$diago."', '".$pills."', '".$times."', '".$result."')");
            header("Location: prescriptions.php");
       
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Clinic Website</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/bootstrap-datepicker.css">

</head>
<body>
   
<?php

    require("header.php");

?>

<br />
<br />
<br />
<br />
		 
<section class="contact" id="contact">

   <h1 class="heading">Add Prescription</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <ul style="color: red; font-size: 16px;margin-left:20px">
            <?php

                if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
                    if($error_message != ""){
                        echo $error_message;
                    }
                    else {
                        echo $success_message;
                    }

                }

            ?>
        </ul>

      <span>Patient:</span>
      <select class="box form-control" name="patient" style="height:auto">
            <?php 
                while($row = mysqli_fetch_assoc($patients)){
                    echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                }
            ?>
    </select>
      <span>Medication:</span>
      <select class="box form-control" name="medication" style="height:auto">
            <?php 
                while($row = mysqli_fetch_assoc($medications)){
                    echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                }
            ?>
    </select>
	   <span>Choose a test:</span>
      <select class="box form-control" name="checkup" style="height:auto">
            <?php 
                while($row = mysqli_fetch_assoc($checkups)){
                    echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                }
            ?>
    </select>
	    <span>Your Diagnosis:</span>
      <input type="text" name="diago" placeholder="Type your comments" class="box" >

    <span>Number of Pills:</span>
      <input type="number" name="pills" min="1" max="5" placeholder="How many pills to take" class="box" >

      <span>Times per Day:</span>
      <input type="number" name="times" min="1" max="5" placeholder="How many times per day" class="box" >
          <span>Result:</span>
      <input type="text" name="result"  placeholder="Enter your result" class="box" >
	  
      <input type="submit" value="Create Prescription" name="submit" class="link-btn">
	  <input type="reset" name="reset" value="Clear"  class="link-btn"/>
   </form>  

</section>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<?php

require("footer.php");

?>

</body>
</html>
