<?php 


define("TITLE","EVENT DETAIL | EVENT+");
define("current","event");
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
?>

<div class="event-content">
   <div class="event-card">
       <img src="../asset/event.jpg" alt="event" style="width:100%">
        <div class="event-container">
            <h1 style="display: inline; margin-right:50px;"><?php echo $event['eventTitle']; ?></h1>
            <hr>
            <h2><span class="box">Description</span></h2>
            <h3>&emsp;&#x25BA; <?php echo $event['description']; ?></h3>
            <hr>
            <h2><span class="box">Date And Time</span></h2>
            <h3>&emsp;&#x25BA; <?php echo $event['startDate']; ?></h3>
            <h3>&emsp;&#x25BA; <?php echo $event['startTime']; ?> - <?php echo $event['endTime']; ?></h3>
            <hr>
            <h2><span class="box">Venue</span></h2>
            <h2>&emsp;&#x25BA; <?php echo $event['venue']; ?></h2>
            <hr>
            <h2><span class="box">Vacancy</span></h2>
            <h2>&emsp;&#x25BA; <?php echo $event['seatCapacity']; ?> Seats</h2>
            <hr>
            <h2><span class="box">Price</span></h2>
            <h2>&emsp;&#x25BA; RM <?php echo $event['ticketPrice']; ?></h2>
            <hr>
            <h2><span class="box">Organizer</span></h2>
            <h2>&emsp;&#x25BA;<?php echo $event['organizer']; ?></h2>
            <hr>
       </div>
       <button id="buy-ticket-btn" class="register-ticket-btn">Purchase Ticket</button>
   </div>   
</div>



<link rel="stylesheet" href="../Ticket/ticket_styles.css">
<!--Ticket purchase pop up-->
<!--Modal starts here -->
<div id="myModal" class="modal">
  <form method = "get" action="../Ticket/payment.php" onsubmit="return checkcapacity()">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Select Tickets</h2>
    </div>
    
    <div class="modal-body">
        <div class="body-content">
            <p><font size="5"><?php
            echo $event["eventTitle"];
            ?></font></p>

            <p><?php 
                echo "RM" .number_format($event["ticketPrice"],2);
            ?></p>
            <input type="hidden" name ="eventId" value = "<?php echo $event['eventId'];?>"> <!-- PASS EVENT ID -->
            <p >
                <select name = "total_ticket" id="total_ticket"> 
                    <option value ="1">1</option>
                    <option value ="2">2</option>
                    <option value ="3">3</option>
                    <option value ="4">4</option>
                    <option value ="5">5</option>
                    <option value ="6">6</option>
                    <option value ="7">7</option>
                    <option value ="8">8</option>
                    <option value ="9">9</option>
                    <option value ="10">10</option>
                </select>
                <?php 
                    if(isset($_REQUEST["total_ticket"]))
                    {
                        $amount = $_REQUEST["total_ticket"] * $event["ticketPrice"];
                        $_POST["amount"] = $amount;
                        #echo $_POST["amount"];
                        
                    }
                ?>
            </p>
        </div>
    </div>
    
    <div class="modal-footer">
        <input type = "submit" id="purchase" name="purchase" value = "Purchase">
    </div>
    
  </div>
  </form>
  
  <script>
    function checkcapacity()
    {
        var capacity = parseInt("<?php echo $event["seatCapacity"]?>");
        var total_ticket = parseInt(document.getElementById("total_ticket").value);
        if (total_ticket > capacity)
        {
            alert("Seat capacity left: "+ capacity);
            return false;
        }
        else
        {
            return true;
        }
        
        
        
    }
  </script>
</div>

<script>
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("buy-ticket-btn");
    var span = document.getElementsByClassName("close")[0]; 
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>



