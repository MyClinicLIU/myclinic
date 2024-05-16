<?php

session_start();

if(isset($_SESSION["valid_login"]) && $_SESSION["valid_login"]){
   header("Location: index.php");
}

include_once "dbconnect.php";

function val($data){
   $data = trim($data); // Will trim the data, removes any unnecessary spaces
   $data = stripslashes($data); // Removes any unnecessary backslashes
   $data = htmlspecialchars($data); // Securing the data by using the htmlspecialchars function
   return $data;
}

$error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

   $success_message = "";

   $name = val($_POST["name"]);
   $email_address = val($_POST["email"]);
   $phone_number = val($_POST["number"]);
   $password = val($_POST["password"]);
   $account_type = val($_POST["accounttype"]);

   if(empty($name)){
       $error_message .= "<li>Error: Name is required!</li>";
   }
   if(!preg_match("/^[a-zA-z ]*$/", $name)){
       $error_message .= "<li>Error: Name can only contain letters and whitespaces!</li>";
   }
   if(empty($email_address)){
       $error_message .= "<li>Error: Email is required!</li>";
   }
   if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)){
      $error_message .= "<li>Error: Invalid Email Address!</li>";
  }
   if(empty($phone_number)){
      $error_message .= "<li>Error: Phone Number is required!</li>";
  }
   
   
   if($error_message == ""){

       $user = mysqli_query($conn, "SELECT id FROM users WHERE email_address = '".$email_address."'");

       if(mysqli_num_rows($user) != 0){
           $error_message = "<li>Error: Username already in use!</li>";
       }
       else {
           $password = password_hash($password, PASSWORD_DEFAULT);

           mysqli_query($conn, "INSERT into users (account_type, name, email_address, phone_number, password, verified) VALUES ('".$account_type."', '".$name."', '".$email_address."', '".$phone_number."', '".$password."', '0')");
           $success_message = "<li style='color: green'>Registration Successful!</li>";
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

</head>
<body>
   
<?php

    require("header.php");

?>

<br />
<br />
<br />
<br />
	<section class="about" id="about">

   <div class="container">

      <div class="row align-items-center">

         <div class="col-md-6 image">
            <img src="images/regs.jpg" class="w-100 mb-5 mb-md-0" alt="">
         </div>

         <div class="col-md-6 content">
            <span>Sign-up</span>
			<h3>Create an Account<h3>
            
            <p style="color:red">Please note: You'll need to wait untel the Admin Accept your request! It will take a few minutes. 
			You must be 18 or older to create a Patient Online Services account. Parents must create caregiver accounts for patients under 18.</p>
        
         </div>

      </div>

   </div>

</section>	 
		 
<section class="contact" id="contact">

   <h1 class="heading">Sign-up</h1>

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
      <span>your name :</span>
      <input type="text" name="name" placeholder="enter your name" class="box" >
      <span>your email :</span>
      <input type="email" name="email" placeholder="enter your email" class="box" >
      <span>your number :</span>
      <input type="text" name="number" placeholder="enter your number" class="box" >
	  <span>your password :</span>
      <input type="password" name="password" placeholder="enter your password" class="box" >
    <h3 style="color:var(--blue) ">Account Type:</h3>
		<br />
	   <p>
    <input type="radio" id="test1"  value="Patient" name="accounttype" checked>
    <label for="test1" style="font-size:15px">Patient</label>
  </p><br />
  <p>
    <input type="radio" id="test3" value="Doctor" name="accounttype">
    <label for="test3" style="font-size:15px">Doctor</label>
  </p><br />
      <input type="submit" value="signup" name="submit" class="link-btn">
	  <input type="reset" name="reset" value="Clear"  class="link-btn"/>
   </form>  

</section>

<?php

require("footer.php");

?>

</body>
</html>
