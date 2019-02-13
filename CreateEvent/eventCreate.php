<?php 

require_once '../includes/config.php';
define("TITLE","Create Event | Event+");
define("current","create");
include('../includes/header.php');

$eventTitleErr = $organizerErr = $venueErr = $descriptionErr = $seatCapacityErr = $ticketPriceErr = $startDateErr = $endDateErr = $startTimeErr = $endTimeErr = "";

$eventTitle = $organizer = $venue = $description = $seatCapacity = $ticketPrice = $startDate = $endDate = $startTime = $endTime = "";


//check if the user login or not. If not, take user to login page.
if(!isset($_SESSION['userId'])){
	echo "<script type='text/javascript'> alert('You have to log in first!'); window.location = '../Registration-and-Login/loginPage.php';</script>";
}else{
		$userId = $_SESSION['userId'];
		//check if any field is empty
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
			if(empty(trim($_POST["eventTitle"]))){
				$eventTitleErr = "This field is required";
			}else{
				$eventTitle = trim($_POST["eventTitle"]);
			}

			if(empty(trim($_POST["organizer"]))){
				$organizerErr = "This field is required";
			}else{
				$organizer = trim($_POST["organizer"]);
			}
			
			if(empty(trim($_POST["venue"]))){
				$venueErr = "This field is required";
			}else{
				$venue = trim($_POST["venue"]);
			}
			
			if(empty(trim($_POST["description"]))){
				$descriptionErr = "This field is required";
			}else{
				$description = trim($_POST["description"]);
			}
			
			if(empty(trim($_POST["seatCapacity"]))){
				$seatCapacityErr = "This field is required";
			}else{
				$seatCapacity = trim($_POST["seatCapacity"]);
			}

			if(empty(trim($_POST["ticketPrice"]))){
				$ticketPriceErr = "This field is required";
			}else{
				$ticketPrice = trim($_POST["ticketPrice"]);
			}
			
			$todayDate = date('Y-m-d');
			if(empty(trim($_POST["startDate"]))){
				$startDateErr = "This field is required";
			}elseif ( trim($_POST["startDate"]) < $todayDate ) {
				$startDateErr = "Start date should be equal or later than today date.";
			}else{
				$startDate = trim($_POST["startDate"]);
			}
			
			if(empty(trim($_POST["endDate"]))){
				$endDateErr = "This field is required";
			}else{
				$endDate = trim($_POST["endDate"]);
			}
			
			if(empty(trim($_POST["startTime"]))){
				$startTimeErr = "This field is required";
			}else{
				$startTime = trim($_POST["startTime"]);
			}
			
			if(empty(trim($_POST["endTime"]))){
				$endTimeErr = "This field is required";
			}else{
				$endTime = trim($_POST["endTime"]);
			}

			// check the before and after date
			if(empty($startDateErr)&&empty($endDateErr)){

				if($startDate>$endDate){
					$startDateErr = "Start date should be before end date";
					$endDateErr = "End date should be after start date";
				}
			}

			// check the before and after time
			if(empty($startTimeErr)&&empty($endTimeErr)){
				if($startTime>=$endTime){
					$startTimeErr = "Start time should be before end time";
					$endTimeErr = "End time should be after start time";
				}
			}
			
			if(empty($eventTitleErr) && empty($venueErr) && empty($organizerErr) && empty($descriptionErr) && empty($seatCapacityErr) && empty($ticketPriceErr) && empty($startDateErr) && empty($endDateErr) && empty($startTimeErr) && empty($endTimeErr)){
				
				$query = "INSERT INTO events (eventTitle,organizer,venue,description,seatCapacity,ticketPrice,startDate,endDate,startTime,endTime,userId)
						  values (?,?,?,?,?,?,?,?,?,?,?)";
				if($stmt = mysqli_prepare($link,$query)){
					mysqli_stmt_bind_param($stmt,"ssssiissssi",$eventTitle,$organizer,$venue,$description,$seatCapacity,$ticketPrice,$startDate,$endDate,$startTime,$endTime,$userId);
					if(mysqli_stmt_execute($stmt)){
						echo "<script type='text/javascript'> alert('EVENT CREATED SUCCESSFULLY!'); window.location = '../HomePage/home.php';</script>";
		            } else{
		            	echo "<script type='text/javascript'> alert('Something went wrong. Please try again later.');";
		            }
				}
			}else {
				echo "<script type='text/javascript'> alert('Invalid Input!'); </script>";
			}
		}
	}

?> 

<div class="event-reg-content">
   
   <h1>Event Detail</h1>
   
   <hr>
   
    <div class="event-registration-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>
                <h2><span class="numBox">1</span>Event Title:</h2> <input type = "text" autofocus="on" name = "eventTitle" placeholder ="Enter Event Title"
                value = "<?php echo $eventTitle ?>">
            </label><span class="error"><?php echo $eventTitleErr ?></span>
            <br><hr class="break"><br>
             <label>
                <h2><span class="numBox">2</span>Organizer:</h2><input type = "text" name = "organizer" value = "<?php echo $organizer ?>">
            </label><span class="error"><?php echo $organizerErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">2</span>Venue:</h2><input type = "text" name = "venue" value = "<?php echo $venue ?>">
            </label><span class="error"><?php echo $venueErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">3</span>Description about the event:(Max. 38 Words)</h2> 
                <textarea name="description" cols="100" rows="10"> <?php echo $description ?> </textarea> 
            </label><span class="error"><?php echo $descriptionErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">4</span>Seat Capacity:</h2> <input type = "number" min = "0" name = "seatCapacity"
                value = "<?php echo $seatCapacity ?>">
            </label><span class="error"><?php echo $seatCapacityErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">4</span>Ticket Price:</h2> <input type = "number" min = "0" name = "ticketPrice"
                value = "<?php echo $ticketPrice ?>">
            </label><span class="error"><?php echo $ticketPriceErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">5</span>Start Date: </h2><input type = "date" name = "startDate"
                value = "<?php echo $startDate ?>">
            </label><span class="error"><?php echo $startDateErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">6</span>End Date:</h2> <input type = "date" name = "endDate"
                value = "<?php echo $endDate ?>">
            </label><span class="error"><?php echo $endDateErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">7</span>Start Time:</h2> <input type = "time" name = "startTime"
                value = "<?php echo $startTime ?>">
            </label><span class="error"><?php echo $startTimeErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">8</span>End Time:</h2> <input type = "time" name = "endTime"
                value = "<?php echo $endTime ?>">
            </label><span class="error"><?php echo $endTimeErr ?> </span>
            <br><hr class="break"><br>
            <input type = "submit" class="submit-btn" value = "REGISTER">

        </form>
    </div>
</div>
