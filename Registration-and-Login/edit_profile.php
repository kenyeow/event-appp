<?php

define("TITLE", "My Profile | EVENT+");
define("current","editProfile");
include('../includes/header.php');
$phone_no_err= "";

require_once'config.php';

	$userId=$_SESSION["userId"];
	$sql= "SELECT * FROM users WHERE Userid='$userId'";
	$query1=mysqli_query($link, $sql);
	$result=mysqli_fetch_array($query1);

	$name_err=$email_err=$pwd_err="";

	if(isset($_POST['submit'])){

		if (isset($_POST['name'])){
			$sql = "SELECT Userid FROM users WHERE name = ?";
        	if($stmt = mysqli_prepare($link, $sql)){
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "s", $param_name);
	         
	            // Set parameters
	            $param_name = trim($_POST["name"]);
	            
	            // Attempt to execute the prepared statement
	            if(mysqli_stmt_execute($stmt)){
	            	mysqli_stmt_store_result($stmt);
	            	mysqli_stmt_bind_result($stmt,$resultUserId);
	            	if(mysqli_stmt_fetch($stmt)){
	            		if(mysqli_stmt_num_rows($stmt) == 1 && $resultUserId != $userId){
	                		$name_err = "Username is already taken.";
	                	}
	            	}
	            }else{ echo "Oops! Something went wrong. Please try again later.";}
        	}
    	}	
	

	if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email address.";
    }elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format."; 
    }else{
        // Prepare a select statement
        $sql = "SELECT Userid FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
			$param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
	            mysqli_stmt_bind_result($stmt,$resultUserId);
	            if(mysqli_stmt_fetch($stmt)){
	            	if(mysqli_stmt_num_rows($stmt) == 1 && $userId != $resultUserId){
                    	$email_err = "This email is already taken.";
                	}
	            }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }

    if(empty(trim($_POST['phone_no']))){
        $phone_no_err = "Enter you phone number";     
    }else{
    	$phone_no = $_POST['phone_no'];
    }
	
    // Validate password
    if(empty(trim($_POST['pwd']))){
        $pwd = '';   
    } elseif(strlen(trim($_POST['pwd'])) < 8){
        $pwd_err = "Password must have at least 8 characters.";
    }else{
    	$pwd = trim($_POST['pwd']);  
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

	if(empty($name_err) && empty($email_err) && empty($phone_no_err) && empty($pwd_err)){
	
		if(empty($pwd)){
			$sql2= "UPDATE users SET name='$name', email='$email', phone_no= '$phone_no' WHERE Userid='$userId'";
			$s=mysqli_query($link, $sql2);
		}else{
		$hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
		$sql2= "UPDATE users SET name='$name', email='$email', phone_no= '$phone_no', pwd='$hash_pwd' WHERE Userid='$userId'";
		$s=mysqli_query($link, $sql2);
		}
		$Message = "Update Successful!";
		echo "<script type='text/javascript'>alert('$Message');
		window.location.href='../HomePage/home.php';</script>";
	}
}

?>

<div class="event-reg-content">
      
<form  action="edit_profile.php" method="POST">
<h1>Edit Profile</h1> 
<hr>
<div class="event-registration-form">
			<label>
            <h2><span class="numBox">1</span>Username</h2> <input type = "text" name = "name" value="<?php  echo $result['name']; ?>" >
            <br><span><?php echo "$name_err"; ?></span>
			</label>
            <hr>
			<label>
                <h2><span class="numBox">2</span>Email Address</h2> <input type = "email" name = "email" value="<?php  echo $result['email'];  ?>">
                <br><span><?php echo "$email_err"; ?></span>
			</label>
            <hr>
			<label>
                <h2><span class="numBox">3</span>Phone number</h2> <input type = "tel" name = "phone_no" pattern = "\d{3}-\d{7}" value="<?php  echo $result['phone_no'];  ?>" placeholder = "###-#######">
				<br><span><?php echo "$phone_no_err"; ?></span>

			</label>
            <hr>
			<label>
                <h2><span class="numBox">4</span>Password</h2> <input type = "password" name = "pwd" placeholder = "xxxxxxxxxxx">
                <br><span><?php echo "$pwd_err"; ?></span>
            </label> <br>
            <hr>
            <input class="submit-btn" type="submit" name="submit" value = "Update">
			
</div>
</form>
</div>

</body>
</html>