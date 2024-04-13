<?php

session_start();

if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Patient"){
    header("Location: index.php");
 }

$conn = mysqli_connect('localhost','root','','myclinic') or die('connection failed');

$patient_id = $_SESSION["id"];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
    $error_message = "";
    $success_message = "";

    $meeting_id = $_POST["meeting"];

    $meeting = mysqli_query($conn, "SELECT date, time FROM meetings WHERE id = ".$meeting_id);
    $meeting_row = mysqli_fetch_assoc($meeting);
    $date = $meeting_row["date"];
    $time = $meeting_row["time"];

    $meeting = mysqli_query($conn, "SELECT id FROM meetings WHERE patient_id = '".$patient_id."' and date = '".$date."' and '".$time."' > SUBTIME(time, '0:5:0') and '".$time."' < ADDTIME(time, '0:5:0')");

    if(mysqli_num_rows($meeting) != 0){
        $error_message = "<li>Error: You already have an appointment in this date and time!</li>";
    }
    else {
        mysqli_query($conn, "UPDATE meetings SET patient_id = '".$patient_id."' WHERE id = ".$meeting_id);
        $success_message = "<li style='color: green'>Appointment Taken Successfully!</li>";
    }
 
}

$appointments = mysqli_query($conn, "SELECT m.id, u1.name doctor, u2.name patient, m.date, m.time 
                                FROM meetings m, users u1, users u2
                                WHERE m.doctor_id = u1.id and m.patient_id = u2.id and m.patient_id = ".$patient_id);

$available_meetings = mysqli_query($conn, "SELECT m.id, u1.name doctor, m.date, m.time 
                                FROM meetings m, users u1
                                WHERE m.doctor_id = u1.id and m.patient_id is null");



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

</head>
<body>
   
<?php

    require("header.php");

?>

<br />
<br />
<br />
<br />
<br />
<br />
<section class="about" id="about">

   <div class="container">
    <h1 style="text-align:center">Your Appointments</h1>
    <br>
    <br>
    <br>
    <?php 
        if(mysqli_num_rows($appointments) == 0){
            echo "<h2 class='login-title'>No Appointments</h2>";
        }
     ?>
    <div class="table-responsive <?php if(mysqli_num_rows($appointments) == 0) echo 'd-none'; ?>">
        <table class="table table-striped">
            <thead style="font-size: 20px">
            <tr>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody style="font-size: 16px">
            <?php

                while($row = mysqli_fetch_assoc($appointments)){
                    echo "<tr>";
                    
                    echo "<td>".$row["doctor"]."</td>";
                    echo "<td>".$row["date"]."</td>";
                    echo "<td>".$row["time"]."</td>";

                    echo "<td><a href='deleteappointment.php?id=".$row["id"]."'>Delete</a></td>";

                    echo "</tr>";

                }
            ?>
            
            </tbody>
        </table>
    </div>
   </div>

</section>	 

<section class="contact">

    <?php 
        if(mysqli_num_rows($available_meetings) == 0){
            echo "<h2 class='heading'>No Available Appointments to Take</h2>";
        }
        else {
            echo '<h1 class="heading">Take Appointment</h1>';
        }
     ?>
   

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class=" <?php if(mysqli_num_rows($available_meetings) == 0) echo 'd-none'; ?>">
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
      <span>Appointment:</span>
      <select class="box form-control" name="meeting" style="height:auto">
            <?php 
                while($row = mysqli_fetch_assoc($available_meetings)){
                    echo "<option value='".$row["id"]."'>".$row["doctor"]." on ".$row["date"]." at ".$row["time"]."</option>";
                }
            ?>
      </select>
    
      <input type="submit" value="Take Appointment" name="submit" class="link-btn">
   </form>  

</section>
	
<?php

require("footer.php");

?>

</body>
</html>