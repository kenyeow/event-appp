<?php
require_once('../includes/config.php');

$events=array();

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!empty(trim($_POST["searchTitle"]))){
		$searchTitle = trim($_POST["searchTitle"]);
		$query = "SELECT eventId,eventTitle,organizer,venue,description,seatCapacity,ticketPrice,startDate,endDate,startTime,endTime FROM
		  events where eventTitle LIKE CONCAT('%',?,'%')";
		$stmt = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($stmt,"s",$searchTitle);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			mysqli_stmt_bind_result($stmt,$eventId,$eventTitle,$organizer,$venue,$description,$seatCapacity,$ticketPrice,$startDate,$endDate,$startTime,$endTime); 
			while(mysqli_stmt_fetch($stmt)){
				$newEvent=array("eventId"    => $eventId,
                                "eventTitle" => $eventTitle,
								"organizer" => $organizer,
								"venue" => $venue,
								"description" => $description,
								"seatCapacity" => $seatCapacity,
								"ticketPrice" => $ticketPrice,
								"startDate" => $startDate,
								"endDate"=> $endDate,
								"startTime" => $startTime,
								"endTime" => $endTime);
				$events[]=$newEvent;
			}
			session_start();
			$_SESSION['eventList']=$events;
			header("location: ../Search/search.php");
		}else{
			echo "Oops! Something went wrong. Please try again later.";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
	}else{
		header("location: ../Search/search.php");
	}
}

if(isset($_GET['userId'])) {
	$userId = $_GET['userId'];
		$query = "SELECT eventId,eventTitle,organizer,venue,description,seatCapacity,ticketPrice,startDate,endDate,startTime,endTime FROM
		  events where userId LIKE ?";
		$stmt = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($stmt,"i",$userId);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			mysqli_stmt_bind_result($stmt,$eventId,$eventTitle,$organizer,$venue,$description,$seatCapacity,$ticketPrice,$startDate,$endDate,$startTime,$endTime); 
			while(mysqli_stmt_fetch($stmt)){
				$newEvent=array("eventId"    => $eventId,
                                "eventTitle" => $eventTitle,
								"organizer" => $organizer,
								"venue" => $venue,
								"description" => $description,
								"seatCapacity" => $seatCapacity,
								"ticketPrice" => $ticketPrice,
								"startDate" => $startDate,
								"endDate"=> $endDate,
								"startTime" => $startTime,
								"endTime" => $endTime);
				$events[]=$newEvent;
			}
			session_start();
			$_SESSION['eventList']=$events;
			header("location: ../MyEvent/myEvent.php");
		}	
}
		

?>