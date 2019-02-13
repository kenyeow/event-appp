<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$email = $pwd = "";
$email_err = $pwd_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = 'Please enter email.';
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['pwd']))){
        $pwd_err = 'Please enter password.';
    } else{
        $pwd = trim($_POST['pwd']);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($pwd_err)){
        // Prepare a select statement
        $sql = "SELECT Userid,name,email, pwd FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $userId,$userName, $email, $hashed_pwd);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($pwd, $hashed_pwd)){
                            /* Password is correct, so start a new session and
                            save the email to the session */
                            session_start();
                            $_SESSION['userId'] = $userId;
                            $_SESSION['userName'] = $userName;
                            header("location: ../HomePage/home.php");
                        } else{
                            // Display an error message if password is not valid
                            $pwd_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = 'No account found with that email.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
