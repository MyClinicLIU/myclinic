<?php

session_start();

if(isset($_SESSION["valid_login"]) && $_SESSION["valid_login"]){
   header("Location: index.php");
}

include_once "db_connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){

   $email_address = $_POST["email"];
   $password = $_POST["password"];

   $logged_in_user = mysqli_query($conn, "SELECT id, account_type, name, phone_number, password, verified FROM users WHERE email_address = '".$email_address."'");

   if(!mysqli_num_rows($logged_in_user)){
       $_SESSION["valid_email"] = false;
   }
   else {
       $_SESSION["valid_email"] = true;

       $logged_in_user_row = mysqli_fetch_assoc($logged_in_user);

       if($logged_in_user_row["verified"] == "0"){
         $_SESSION["verified"] = false;
       }
       else {
         $_SESSION["verified"] = true;

         if(password_verify($password, $logged_in_user_row["password"])){
            $_SESSION["id"] = $logged_in_user_row["id"];
            $_SESSION["account_type"] = $logged_in_user_row["account_type"];
            $_SESSION["name"] = $logged_in_user_row["name"];
            $_SESSION["phone_number"] = $logged_in_user_row["phone_number"];
            $_SESSION["email_address"] = $email_address;
            $_SESSION["password"] = $password;
            $_SESSION["valid_password"] = true;
        }
        else {
            $_SESSION["valid_password"] = false;
        }
       }
   }

   $_SESSION["valid_login"] = $_SESSION["valid_email"] && $_SESSION["verified"] && $_SESSION["valid_password"];

   if($_SESSION["valid_login"]){

      if($_SESSION["account_type"] == "Admin"){
         header("Location: verifyusers.php");
      }
      else if($_SESSION["account_type"] == "Doctor"){
         header("Location: meetings.php");
      }
      else {
         header("Location: appointments.php");
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

<br />
<br />
<section class="contact" id="contact">

   <h1 class="heading" style="font-family:italic">Login</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <ul style="color: red; font-size: 16px;margin-left:20px">
            <?php

                if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
                  if(!$_SESSION["valid_email"]){
                     echo "<li>Error: Invalid Email Address!</li>";
                  }  
                  if(isset($_SESSION["verified"]) && !$_SESSION["verified"]){
                     echo "<li>Error: Account Not Verified!</li>";
                  }  

                  if(isset($_SESSION["valid_password"]) && !$_SESSION["valid_password"]){
                     echo "<li>Error: Invalid Password!</li>";
                  }  
                 
                }

            ?>
        </ul>
      
      <span>your email address :</span>
      <input type="text" name="email" placeholder="enter your email address" class="box" required>
      <span>your password :</span>
      <input type="password" name="password" placeholder="enter your password" class="box" required>
   
  <h3 style="font-family:italic">Do you have an account? If you dont have an account plz click here to create an account</h3>
   <h3><a href="signup.php" style="color:red">Sign-up</a></h3><br />
      <input type="submit" value="login" name="login" class="link-btn">
	  <input type="reset" name="reset" value="Clear"  class="link-btn"/>
   </form>  

</section> 
	
<?php

require("footer.php");

?>

</body>
</html>