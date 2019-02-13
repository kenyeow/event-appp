<?php
require_once 'register.php'
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up</title>
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="close-btn">
             <a href="../HomePage/home.php"><button><span>X</span></button></a>
  </div> 
 
 
  <div class="form">
      <ul class="tab-group">
        <li class="tab active"><a href="registerPage.php">Sign Up</a></li>
        <li class="tab"><a href="loginPage.php">Log In</a></li>
      </ul>
      
      <div class="tab-content">
         
          <h1>Sign Up for Free</h1>
          
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
          
            <div class="field-wrap <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
            <input type="text" name="name" placeholder = "Username*" value="<?php echo $name; ?>" required />
			      <span class="help-block"><?php echo $name_err; ?></span>
            </div>
          

            <div class="field-wrap <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <input type="email" name="email" placeholder = "Email Address*" value="<?php echo $email; ?>" required/>
  			    <span class="help-block"><?php echo $email_err; ?></span>
  		      </div>
  		  
  		      <div class="field-wrap <?php echo (!empty($phone_no_err)) ? 'has-error' : ''; ?>">
            <input type="tel" name="phone_no" placeholder = "Phone Number (###-########)*" pattern = "\d{3}-\d{7}" value="<?php echo $phone_no; ?>" required/>
  			    <span class="help-block"><?php echo $phone_no_err; ?></span>
            </div>
            
            <div class="field-wrap <?php echo (!empty($pwd_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="pwd" placeholder = "Password*" required />
  			    <span class="help-block"><?php echo $pwd_err; ?></span>
  		      </div>

      		  <div class="field-wrap">
            <input type="password" name="confirm_pwd" placeholder = "Confirm Password*"  required />
      			<span class="help-block"><?php echo $confirm_pwd_err; ?></span>
      		  </div>
          
            <button type="submit" class="button button-block">Get Started</button>
        </form>

        
        </div>
        
     </div>
</div> 
</body>
</html>
