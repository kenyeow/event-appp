<?php 

require_once '../includes/config.php';
define("TITLE","Edit Event | Event+");
define("current","editEvent");
include('../includes/header.php');


if(!isset($_SESSION['userId'])){
	    echo "<script type='text/javascript'> alert('You have to log in first!'); window.location = '../Registration-and-Login/loginPage.php';</script>";
		}else{
		    $events = $_SESSION['eventList'];

		    if(isset($_GET['event'])){
		        
		        $ID = $_GET['event'];
		        
		        $key = array_search($ID, array_column($events, 'eventId'));
		        
		        $event = $events[$key];
		        $_SESSION['currentEvent']= $event;
		    }
		}

$eventTitleErr = $organizerErr = $venueErr = $descriptionErr = $seatCapacityErr = $startDateErr = $endDateErr = $startTimeErr = $endTimeErr = "";
$eventTitle = $organizer = $venue = $description = $seatCapacity = $startDate = $endDate = $startTime = $endTime = "";

$event = $_SESSION['currentEvent'];

//check if any field is empty
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(empty(trim($_POST['eventTitle']))){
		$eventTitleErr = "This field is required";
	}else{
		$eventTitle = trim($_POST['eventTitle']);
	}

	if(empty(trim($_POST['organizer']))){
		$organizerErr = "This field is required";
	}else{
		$organizer = trim($_POST['organizer']);
	}
	
	if(empty(trim($_POST['venue']))){
		$venueErr = "This field is required";
	}else{
		$venue = trim($_POST['venue']);
	}
	
	if(empty(trim($_POST['description']))){
		$descriptionErr = "This field is required";
	}else{
		$description = trim($_POST['description']);
	}
	
	if(empty(trim($_POST['seatCapacity']))){
		$seatCapacityErr = "This field is required";
	}else{
		$seatCapacity = trim($_POST['seatCapacity']);
	}
	
	if(empty(trim($_POST['startDate']))){
		$startDateErr = "This field is required";
	}else{
		$startDate = trim($_POST['startDate']);
	}
	
	if(empty(trim($_POST['endDate']))){
		$endDateErr = "This field is required";
	}else{
		$endDate = trim($_POST['endDate']);
	}
	
	if(empty(trim($_POST["startTime"]))){
		$startTimeErr = "This field is required";
	}else{
		$startTime = trim($_POST["startTime"]);
	}
	
	if(empty(trim($_POST['endTime']))){
		$endTimeErr = "This field is required";
	}else{
		$endTime = trim($_POST['endTime']);
	}
	
	if(empty($eventTitleErr) && empty($venueErr) && empty($descriptionErr) && empty($seatCapacityErr) 
		&& empty($startDateErr) && empty($endDateErr) && empty($startTimeErr) && empty($endTimeErr)){
		$query = "UPDATE events SET eventTitle='$eventTitle', organizer='$organizer', venue='$venue', description='$description', seatCapacity='$seatCapacity',startDate='$startDate',endDate='$endDate',startTime='$startTime',endTime='$endTime' WHERE eventId = '$event[eventId]'";
		if($stmt = mysqli_prepare($link,$query)){
			if(mysqli_stmt_execute($stmt)){
				// Go to array.php then head back to myEvent.php
				echo "<script type='text/javascript'> alert('UPDATE SUCCESSFULLY!'); window.location = '../includes/array.php?userId= $_SESSION[userId]'; </script>"; 
            } else {
                echo "Something went wrong. Please try again later.";
            }
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
                value = "<?php echo $event['eventTitle'] ?>">
            </label><span class="error"><?php echo $eventTitleErr ?></span>
            <br><hr class="break"><br>
             <label>
                <h2><span class="numBox">2</span>Organizer:</h2><input type = "text" name = "organizer" value = "<?php echo $event['organizer'] ?>">
            </label><span class="error"><?php echo $organizerErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">2</span>Venue:</h2><input type = "text" name = "venue" value = "<?php echo $event['venue'] ?>">
            </label><span class="error"><?php echo $venueErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">3</span>Description about the event:(Max. 38 Words)</h2> 
                <textarea name="description" cols="100" rows="10"> <?php echo $event['description'] ?> </textarea> 
            </label><span class="error"><?php echo $descriptionErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">4</span>Seat Capacity:</h2> <input type = "number" name = "seatCapacity"
                value = "<?php echo $event['seatCapacity'] ?>">
            </label><span class="error"><?php echo $seatCapacityErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">5</span>Start Date: </h2><input type = "date" name = "startDate"
                value = "<?php echo $event['startDate'] ?>">
            </label><span class="error"><?php echo $startDateErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">6</span>End Date:</h2> <input type = "date" name = "endDate"
                value = "<?php echo $event['endDate'] ?>">
            </label><span class="error"><?php echo $endDateErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">7</span>Start Time:</h2> <input type = "time" name = "startTime"
                value = "<?php echo $event['startTime'] ?>">
            </label><span class="error"><?php echo $startTimeErr ?> </span>
            <br><hr class="break"><br>
            <label>
                <h2><span class="numBox">8</span>End Time:</h2> <input type = "time" name = "endTime"
                value = "<?php echo $event['endTime'] ?>">
            </label><span class="error"><?php echo $endTimeErr ?> </span>
            <br><hr class="break"><br>
            <input type = "submit" class="submit-btn" value = "Update">

        </form>
    </div>
</div>
