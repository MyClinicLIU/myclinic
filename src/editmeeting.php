<?php

session_start();

if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Doctor"){
    header("Location: index.php");
 }

include_once "dbconnect.php";

$doctor_id = $_SESSION["id"];

$meeting_id = $_GET["id"];

$meeting = mysqli_query($conn, "SELECT m.date, m.time 
                                FROM meetings m
                                LEFT JOIN users u1 ON m.doctor_id = u1.id
                                LEFT JOIN users u2 ON m.patient_id = u2.id 
                                WHERE m.doctor_id = ".$doctor_id." and m.id = ".$meeting_id);

$row = mysqli_fetch_assoc($meeting);

function val($data){
   $data = trim($data); // Will trim the data, removes any unnecessary spaces
   $data = stripslashes($data); // Removes any unnecessary backslashes
   $data = htmlspecialchars($data); // Securing the data by using the htmlspecialchars function
   return $data;
}

$error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

   $success_message = "";

   $date = val($_POST["date"]);
   $time = val($_POST["time"]);

   if(empty($date)){
       $error_message .= "<li>Error: Date is required!</li>";
   }
   if(empty($time)){
       $error_message .= "<li>Error: Time is required!</li>";
   }
   
   if($error_message == ""){

        $meeting = mysqli_query($conn, "SELECT id FROM meetings WHERE date = '".$date."' and time = '".$time."' and id != ".$meeting_id);

        if(mysqli_num_rows($meeting) != 0){
            $error_message = "<li>Error: Meeting Date and Time already in use!</li>";
        }
        else {
            mysqli_query($conn, "UPDATE meetings SET date = '".$date."', time = '".$time."' WHERE id = ".$meeting_id);
            header("Location: meetings.php");
        }
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

   <h1 class="heading">Edit Meeting</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $meeting_id ?>" method="post">
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

      <span>Meeting Date:</span>
      <input type="text" name="date" class="box form-control datepicker" placeholder="Meeting Date" readonly value="<?php echo $row["date"] ?>">
      <span>Meeting Time:</span>
      <input type="text" name="time" placeholder="Meeting Time" class="box" value="<?php echo $row["time"] ?>" >
    
      <input type="submit" value="Save Meeting" name="submit" class="link-btn">
	  <input type="reset" name="reset" value="Clear"  class="link-btn"/>
   </form>  

</section>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<script>
    $('.datepicker').datepicker({
        startDate: "+1d",
        format: "dd-mm-yyyy"
    });
</script>

<?php

require("footer.php");

?>

</body>
</html>
