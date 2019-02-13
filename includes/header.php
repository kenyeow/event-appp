<?php
  session_start();
  
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title><?php echo TITLE; ?></title>
        <link rel="stylesheet" type="text/css" href="../asset/custom.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">

    </head>
    
    <body>
        <div class="navbar">
              <a href="../HomePage/home.php" class="logo"><b>EVENT </b><sup>+</sup></a>
              <a href="../AboutUs/About.php" <?php if( current == 'about') {echo 'class="current"';} ?> >About Us</a>
              <a href="../CreateEvent/eventCreate.php?page=create" <?php if( current == 'create') {echo 'class="current"';} ?> >Create Event</a> 
              <div class="dropdown">
				        <button href="#" class="dropbtn"><?php $name = isset($_SESSION['userName']) ? $_SESSION['userName'] : "Guest"; echo $name; ?></button>
				        <div class="dropdown-content">

                  <a href="../Registration-and-Login/edit_profile.php" <?php if( current == 'editProfile') {echo 'class="current"';} 
                  if(!isset($_SESSION['userId'])){echo 'class="notlogin"';} ?> >My Profile</a>

					         <a href="../MyTicket/myTicket.php" <?php if( current == 'myTicket') {echo 'class="current"';}
                   if(!isset($_SESSION['userId'])){echo 'class="notlogin"';} ?> >My Ticket</a>

					         <a href="../includes/array.php?userId=<?php echo $_SESSION['userId']; ?>" <?php if( current == 'myEvent') {echo 'class="current"';}
                   if(!isset($_SESSION['userId'])){echo 'class="notlogin"';} ?> >My Event</a>
                   <?php $loginStatus = isset($_SESSION['userId']) ? "Logout" : "Login"; ?>

					         <a href=" <?php if(isset($_SESSION['userId'])){ echo "../Registration-and-Login/logout.php ";}else{ echo "../Registration-and-Login/loginPage.php ";} ?> "> <?php echo $loginStatus; ?> </a>
				        </div>
			        </div>
        </div>

       