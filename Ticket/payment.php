
<!DOCTYPE html>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="payment_style.css">
		<title>Payment</title>
	</head>
	
	<body>
		<?php 
			include ("config.php");
			session_start();
			$userId = $_SESSION['userId'];
			$total_ticket = $_GET["total_ticket"];
			$eventId = $_GET["eventId"];
			$sql= "SELECT * from events where eventId = $eventId"; 
			$event_details = $link-> query ($sql);
			$event = $event_details->fetch_assoc();
			$amount = $event["ticketPrice"] * $total_ticket;
		?>
		<form name = "payment_form" method = "post" onsubmit="return required()">
			<div class ="form_size"> <h1> Payment </h1></div>
			<div class = "display_event"><strong> Event details </strong><br> <?php echo "Event name: ".$event["eventTitle"] ."<br>"."Total amount: "."RM" .number_format("$amount",2)."<br>"."Total ticket: "."$total_ticket"?></div>
			<input id="left" type="text" name="first-name" placeholder="First Name"/>
			<input id="right" type="text" name="last-name" placeholder="Surname"/>
			<input id="middle" type="text" name="number" placeholder="Card Number (xxxx xxxx xxxx xxxx)" maxlength="19" pattern="\d{4} +\d{4} +\d{4} +\d{4}"/>
			<input id="left" type="text" name="expiry" placeholder="MM / YY" pattern="\d{2}\/\d{2}"/> 
			<input id="right" type="text" name="cvc" placeholder="CCV" maxlength="3" pattern="\d{3}"/>
			<input id="submit_button" name= "submit_button" type="submit" value="Submit"/>
		</form>
		<script>
			function required()
			{
				var input1 = document.forms["payment_form"]["first-name"].value;
				var input2 = document.forms["payment_form"]["last-name"].value;
				var input3 = document.forms["payment_form"]["number"].value;
				var input4 = document.forms["payment_form"]["expiry"].value;
				var input5 = document.forms["payment_form"]["cvc"].value;
				if (input1 == "" || input2 == "" || input3 == "" || input4 == "" || input5 == ""){
					alert("All value must be filled.");
					return false;
				}
				else 
					return true;
			}
		</script>
		<?php
			$sql = "INSERT INTO payment (amount) VALUES ('$amount')";
			if ($_SERVER['REQUEST_METHOD'] == 'POST') { #check whether click submit or not
				if (isset($_POST['submit_button'])){
					if($link->query($sql) == true)
					{
						$latest_payment_id = $link->insert_id;
						$latest_capacity = $event["seatCapacity"] - $total_ticket;
						$link->query("INSERT INTO ticket_order(eventId,total_ticket,userId,payment_id) VALUES ('$eventId','$total_ticket','$userId','$latest_payment_id')");
						$link->query("UPDATE events SET seatCapacity = $latest_capacity WHERE eventId = $eventId ");
						echo "<script type='text/javascript'>alert('Your ticket purchase is successful');
						window.location.href='../HomePage/home.php';</script>";
					}
					
				}
			}
		?>
	</body>