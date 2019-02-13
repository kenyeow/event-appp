<?php
require_once 'login.php'
?>
<!DOCTYPE html>
<html >

<head>
  <meta charset="UTF-8">
  <title>LOGIN | Event+</title>
  
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="../asset/custom.css">
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
</head>

<body>
    <div class="close-btn">
             <a href="../HomePage/home.php"><button><span>X</span></button></a>
    </div> 

  <div class="form">
      <ul class="tab-group">
        <li class="tab"><a href="registerPage.php">Sign Up</a></li>
        <li class="tab active"><a href="loginPage.php">Log In</a></li>
      </ul>
    	<div>   
          <h1>Welcome To <span class="logo"><b>EVENT </b><sup>+</sup></span></h1>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
              <div class="field-wrap <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                  <input type="email" name="email" placeholder = "Email Address*" value="<?php echo $email; ?>"/>
        			    <span class="help-block"><?php echo $email_err; ?></span>
              </div>
                  
              <div class="field-wrap <?php echo (!empty($pwd_err)) ? 'has-error' : ''; ?>">      
                  <input type="password" name="pwd" placeholder = "Password*"/>
        			    <span class="help-block"><?php echo $pwd_err; ?></span>
              </div>
                  <button class="button button-block">Log In </button>        
          </form>
        </div>
	</div>
</body>

</html>