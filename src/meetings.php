<?php

session_start();

if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Doctor"){
    header("Location: index.php");
 }

include_once "db_connection.php";

$doctor_id = $_SESSION["id"];

$meetings = mysqli_query($conn, "SELECT m.id, u1.name doctor, u2.name patient, u2.id pid, m.date, m.time 
                                FROM meetings m
                                LEFT JOIN users u1 ON m.doctor_id = u1.id
                                LEFT JOIN users u2 ON m.patient_id = u2.id 
                                WHERE m.doctor_id = ".$doctor_id);

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
    <h1 style="text-align:center">Your Meetings</h1>
    <br>
    <a href="addmeeting.php" class="link-btn">Add Meeting</a>
	  <a href="showpatient.php" class="link-btn">About Patient </a>
    <br>
    <br>
    <br>
    <?php 
        if(mysqli_num_rows($meetings) == 0){
            echo "<h2 class='login-title'>No Meetings</h2>";
        }
     ?>
    <div class="table-responsive <?php if(mysqli_num_rows($meetings) == 0) echo 'd-none'; ?>">
        <table class="table table-striped">
            <thead style="font-size: 20px">
            <tr>
                <th>Patient Name</th>
				<th>View Records</th>
                <th>Date</th>
                <th>Time</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody style="font-size: 16px">
            <?php

                while($row = mysqli_fetch_assoc($meetings)){
                    echo "<tr>";

                    if($row["patient"] == null){
                        echo "<td>-</td>";
                    }
                    else {
                        echo "<td><a href='profile.php?id=".$row["pid"]."'>".$row["patient"]."</a></td>";
                    }
					 echo "<td><a href='prescriptions.php?id=".$row["pid"]." && date=".$row["date"]."'>Show Records</a></td>";
					
                    echo "<td>".$row["date"]."</td>";
                    echo "<td>".$row["time"]."</td>";

                    
                    echo "<td><a href='editmeeting.php?id=".$row["id"]."'>Edit</a></td>";
                    echo "<td><a href='deletemeeting.php?id=".$row["id"]."'>Delete</a></td>";

                    echo "</tr>";

                }
            ?>
            
            </tbody>
        </table>
    </div>
   </div>

</section>	 
	
<?php

require("footer.php");

?>

</body>
</html>