<?php

session_start();

include_once "db_connection.php";

function val($data){
    $data = trim($data); // Will trim the data, removes any unnecessary spaces
    $data = stripslashes($data); // Removes any unnecessary backslashes
    $data = htmlspecialchars($data); // Securing the data by using the htmlspecialchars function
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

    $error_message = "";
    $success_message = "";

    if(empty(val($_POST["name"]))){
        $error_message .= "<li>Error: Name is required!</li>";
    }
    if(!preg_match("/^[a-zA-z ]*$/", $_POST["name"])){
        $error_message .= "<li>Error: Name can only contain letters and whitespaces!</li>";
    }
    if(empty(val($_POST["email"]))){
        $error_message .= "<li>Error: Email is required!</li>";
    }
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $error_message .= "<li>Error: Invalid Email Address!</li>";
    }
    if(empty(val($_POST["number"]))){
        $error_message .= "<li>Error: Number is required!</li>";
    }
    if(empty(val($_POST["message"]))){
        $error_message .= "<li>Error: Message is required!</li>";
    }
    
    if($error_message == ""){

        $name = val($_POST["name"]);
        $email_address = val($_POST["email"]);
        $phone_number = val($_POST["number"]);
        $message = val($_POST["message"]);

        mysqli_query($conn, "INSERT into contactus (name, email_address, phone_number, message) VALUES ('".$name."', '".$email_address."', '".$phone_number."', '".$message."')");
        $success_message = "<li style='color: green'>Contact Us Sent Successful!</li>";

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

<!-- home section starts  -->

<section class="home" id="home">

   <div class="container">

      <div class="row min-vh-100 align-items-center">
         <div class="content text-center text-md-left">
            <h3>Let Us Take Care Of Your Health</h3>
            <p>Good Health And Good Sense Are Two Of Life's Greatest Blessings</p>
            <a href="#contact" class="link-btn">Login</a>
         </div>
      </div>

   </div>

</section>

<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

   <div class="container">

      <div class="row align-items-center">

         <div class="col-md-6 image">
            <img src="images/About.jpg" class="w-100 mb-5 mb-md-0" alt="">
         </div>

         <div class="col-md-6 content">
            <span>about us</span>
            <h3>True Healthcare For Your Family</h3>
            <p>MyClinic is an intuitive and easy to use medical clinic management system ideal for healthcare professionals on the move or who are working from different hospitals.

MyClinic's medical clinic management system Website enables you to work across boundaries, from different platforms and locations.

MyClinic's innovative system provides healthcare record management solutions to private practices for better diagnosis and treatment.</p>
            <a href="#ourteam" class="link-btn">Our Team</a>
         </div>

      </div>

   </div>

</section>

<!-- about section ends -->

<!-- services section starts  -->

<section class="services" id="services">

   <h1 class="heading">our services</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/specialist.svg" alt="">
         <h3>Different specialists</h3>
         <p>Find a specialist in any medical field</p>
      </div>

      <div class="box">
         <img src="images/schedule.svg" alt="">
         <h3>Take an Appointment and Visit us</h3>
         <p>Take an appointment online with the doctor you need!</p>
      </div>

      <div class="box">
         <img src="images/phone.svg" alt="">
         <h3>Contact us For more info</h3>
         <p>Feel Free to contact us at any time</p>
      </div>

      <div class="box">
         <img src="images/records.svg" alt="">
         <h3>Check your medical records</h3>
         <p>Be Able to check all your medical records Online</p>
      </div>

      

      <div class="box">
         <img src="images/prescribtion.svg" alt="">
         <h3>Check your Prescribtions</h3>
         <p>Check all the required medicines for you to be better!</p>
      </div>
      <div class="box">
         <img src="images/money.svg" alt="">
         <h3>Billing Info</h3>
         <p>Proceed to checkout and check your receits and payments</p>
      </div>

   </div>

</section>

<!-- services section ends -->

<!-- process section starts  -->

<section class="process">

   <h1 class="heading">work process</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/1.png" alt="">
         <h3>Visit us for a checkup</h3>
         <p>Book your first general checkup, to be able to diagnose your case and be transferred into a specialist</p>
      </div>

      <div class="box">
         <img src="images/2.png" alt="">
         <h3>Second Visit</h3>
         <p>Visit the doctor that corresponds your needs and talk more about your health</p>
      </div>

      <div class="box">
         <img src="images/3.png" alt="">
         <h3>Take Medicines</h3>
         <p>Consider Taking the prescribed medicines regularly and enjoy having a fruitfull life</p>
      </div>

   </div>

</section>

<!-- process section ends -->

<!-- reviews section starts  -->

<section class="reviews" id="reviews">

   <h1 class="heading"> satisfied clients </h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>Wonderful experience with MyClinic. Dr. Joe was a wonderful surgeon, and the staff was always helpful and kind. They ensured I had a smooth prep, surgery, and follow-up. I am so glad I chose MyClinic and would highly recommend to anyone.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>John Doe</h3>
         <span>satisfied client</span>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>HealthCare service is amazing and the team helped me get things up and running (I selected the import service where they basically set it up for you). Any issues that I have had since then have been resolved with their customer service team's help. So what are you waiting for??!!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Jane Doe</h3>
         <span>satisfied client</span>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p> Great experience! Made a same day appointment on MyClinic and got in right away. The front desk staff and the medical assistant were very nice and helpful. Dr. Martin was great, gave realistic expectations and timelines. I will definitely be back and would recommend the practice!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          
         </div>
         <h3>Micheal Doe</h3>
         <span>satisfied client</span>
      </div>

   </div>

</section>

<!-- reviews section ends -->

<!-- contact section starts  -->

<section class="ourteam" id="ourteam">

   <h1 class="heading"> OUR TEAM </h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/Haidar .jpeg" alt="">
         <p>Wonderful experience with MyClinic. Dr. Joe was a wonderful surgeon, and the staff was always helpful and kind. They ensured I had a smooth prep, surgery, and follow-up. I am so glad I chose MyClinic and would highly recommend to anyone.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Haidar Mokdad</h3>
        
      </div>

      <div class="box">
         <img src="images/Mohamad.jpeg" alt="">
         <p>HealthCare service is amazing and the team helped me get things up and running (I selected the import service where they basically set it up for you). Any issues that I have had since then have been resolved with their customer service team's help. So what are you waiting for??!!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Mohamad Mokdad</h3>
         
      </div>

   </div>
</section>

<section class="contactus">

   <h1 style="color:red" class="heading">Contact-us</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/em.jpg" alt="">
         <h3>Conatct by email:</h3>
         <p style="color:yellow"> Email 1: 12032138@students.liu.edu.lb</p>
		  <p style="color:yellow"> Email 2: 12110073@students.liu.edu.lb</p>
      </div>

      <div class="box">
         <img src="images/call.jpg" alt="">
         <h3>Contact by phone:</h3>
         <p style="color:yellow">Phone 1:81-980 567</p>
		 <p style="color:yellow" >Phone 2:70-690 496</p>
      </div>

      <div class="box">
         <img src="images/mic.jpg" alt="">
         <h3>Office hours:</h3>
         <p style="color:yellow" >Monday till Friday</p>
		   <p style="color:yellow">From 7AM till 10AM</p>
      </div>

   </div>

</section>

<section class="contact" id="contactus">

   <h1 class="heading" style="color:red">Have a question or want to get in touch?
We would love to hear from you</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>#contactus" method="post">
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
      <span> name :</span>
      <?php
        if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"]) {
            echo '<input type="text" name="name" placeholder="enter your name" class="box" >';
        }
        else {
            echo '<input type="text" name="name" placeholder="enter your name" class="box" value="'.$_SESSION["name"].'" >';
        }

       ?>
      <span> email :</span>
      <?php
        if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"]) {
            echo '<input type="email" name="email" placeholder="enter your email" class="box" > ';
        }
        else {
            echo '<input type="email" name="email" placeholder="enter your email" class="box" value="'.$_SESSION["email_address"].'" >';
        }

       ?>
      
      <span>Phone number  :</span>
      <?php
        if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"]) {
            echo '<input type="text" name="number" placeholder="enter your number" class="box" >';
        }
        else {
            echo '<input type="text" name="number" placeholder="enter your number" class="box" value="'.$_SESSION["phone_number"].'" >';
        }

       ?>
      
      <span>Your Message :</span>
      <textarea type="text" name="message" class="box"  ></textarea>
      <input type="submit" value="submit" name="submit" class="link-btn">
   </form>  

</section>

<!-- contact section ends -->

<?php

require("footer.php");

?>

</body>
</html>