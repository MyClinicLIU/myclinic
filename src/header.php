<!-- header section starts  -->

<header class="header fixed-top">

   <div class="container">

      <div class="row align-items-center justify-content-between">

         <a href="#home" class="logo">My<span>Clinic.</span></a>

         <nav class="nav">
            <a href="index.php">home</a>
            <a href="index.php#about">about-us</a>
            <a href="index.php#services">services</a>
            <a href="index.php#reviews">reviews</a>
            <a href="index.php#contactus">contact-us</a>

            <?php
                if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"]) {
                    echo '<a href="signup.php">Sign-up</a>';
                }

                if(isset($_SESSION["valid_login"]) && $_SESSION["valid_login"]) {
                    if(isset($_SESSION["account_type"]) && $_SESSION["account_type"] == "Admin"){
                        echo '<a href="verifyusers.php">Verify Users</a>';
                        echo '<a href="antidotes.php">Medications</a>';
                        echo '<a href="admincontactus.php">Feedbacks</a>';
                    }

                    if(isset($_SESSION["account_type"]) && $_SESSION["account_type"] == "Patient"){
                        echo '<a href="appointments.php">Appointments</a>';
                        echo '<a href="medications.php">Medications</a>';
                    }

                    if(isset($_SESSION["account_type"]) && $_SESSION["account_type"] == "Doctor"){
                        echo '<a href="meetings.php">My Meetings</a>';
                        echo '<a href="prescriptions.php">Prescriptions</a>';
                    }
                }
                
            ?>
            
         </nav>

         <?php
            if(!isset($_SESSION["valid_login"]) || !$_SESSION["valid_login"]) {
                echo '<a href="login.php" class="link-btn">Login</a>';
            }
            else {
                echo '<a href="logout.php" class="link-btn">Logout</a>';
            }
        ?>

         <div id="menu-btn" class="fas fa-bars"></div>

      </div>

   </div>

   <?php
    if(isset($_SESSION["valid_login"]) && $_SESSION["valid_login"]) {
        echo '<h2 class="login-title">Hello '.$_SESSION['name'].'</h2>';
    }
   ?>

</header>

<!-- header section ends -->