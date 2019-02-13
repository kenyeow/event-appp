<?php

session_start();

$_SESSION = array();

session_destroy();

echo "<script type='text/javascript'> alert('Logout Successfully!');
	  window.location = '../HomePage/home.php';</script>;";
?>
