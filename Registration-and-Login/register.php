<?php 

require_once 'config.php';

$name = $email = $phone_no = $pwd = $confirm_pwd = "";
$name_err = $email_err = $phone_no_err = $pwd_err = $confirm_pwd_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT Userid FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This username is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
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
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
	//Validate phone number
	if(empty(trim($_POST['phone_no']))){
        $phone_no_err = "Enter you phone number";     
    } elseif(strlen(trim($_POST['phone_no'])) < 10){
        $phone_no_err = "Your phone number should be 10 values";
    } else{
        $phone_no = trim($_POST['phone_no']);
    }
	
    // Validate password
    if(empty(trim($_POST['pwd']))){
        $pwd_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['pwd'])) < 8){
        $pwd_err = "Password must have at least 8 characters.";
    } else{
        $pwd = trim($_POST['pwd']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_pwd"]))){
        $confirm_pwd_err = 'Please confirm password.';     
    } else{
        $confirm_pwd = trim($_POST['confirm_pwd']);
        if($pwd != $confirm_pwd){
            $confirm_pwd_err = 'Password did not match.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($phone_no_err) && empty($pwd_err) && empty($confirm_pwd_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name, email, phone_no, pwd) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_phone_no, $param_pwd);
            
            // Set parameters
            $param_name = $name;
			$param_email = $email;
			$param_phone_no = $phone_no;
            $param_pwd = password_hash($pwd, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: success.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>