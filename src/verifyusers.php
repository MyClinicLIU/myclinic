<?php

session_start();

if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"] || $_SESSION["account_type"] != "Admin"){
   header("Location: index.php");
}

$conn = mysqli_connect('localhost','root','','myclinic') or die('connection failed');

$users = mysqli_query($conn, "SELECT id, name, email_address, phone_number, verified FROM users WHERE account_type != 'admin'");

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
    <h1 style="text-align:center">Verify Users</h1>
    <br>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead style="font-size: 20px">
            <tr>
                <th>Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Verify/Unverify</th>
				
            </tr>
            </thead>
            <tbody style="font-size: 16px">
            <?php

                while($row = mysqli_fetch_assoc($users)){
                    echo "<tr>";
                    echo "<td>".$row["name"]."</td>";
                    echo "<td>".$row["email_address"]."</td>";
                    echo "<td>".$row["phone_number"]."</td>";

                    if($row["verified"] == "0"){
                        echo "<td><a href='verifyaccount.php?id=".$row["id"]."'>Verify</a></td>";
                    }
                    else {
                        echo "<td><a href='unverifyaccount.php?id=".$row["id"]."'>Unverify</a></td>";
                    }

               
					
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