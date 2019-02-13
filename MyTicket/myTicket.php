<?php
    define("TITLE","My Ticket | Event+");
    define("current","myTicket");
    include('../includes/header.php');
    include('../includes/config.php');
    
    
    $userId = $_SESSION['userId'];

    $sql= "SELECT events.eventTitle, events.startDate, events.venue, events.startTime, ticket_order.total_ticket FROM ticket_order INNER JOIN events ON ticket_order.eventId = events.eventId WHERE ticket_order.userId = $userId";
    $result = mysqli_query($link,$sql);
    $myTicket = array();
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $ticket = array('eventTitle'=>$row['eventTitle'],
                        'startDate'=>$row['startDate'],
                        'venue'=>$row['venue'],
                        'startTime'=>$row['startTime'],
                        'total_ticket'=>$row['total_ticket']);
        $myTicket[]=$ticket;
      }
    }

    $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
    $total = count( $myTicket); //total items in array    
    $limit = 3; //per page    
    $totalPages = ceil( $total/ $limit ); //calculate total pages
    
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;
    $myTicket = array_slice( $myTicket, $offset, $limit );
    $link = 'myTicket.php?page=%d';
    $pagerContainer = '<div style="position: relative; margin-top:5px;">';   

    if( $totalPages != 0 ) 
    {
      if( $page != 1 ) 
      { 
        $pagerContainer .= sprintf( '<a href="' . $link . '" style="color: #c00"> &#171; prev page</a>', $page - 1 ); 
      } 
      
      $pagerContainer .= ' <span> page <strong>' . $page . '</strong> from ' . $totalPages . '</span>'; 
      if( $page != $totalPages ) 
      { 
        $pagerContainer .= sprintf( '<a href="' . $link . '" style="color: #c00"> next page &#187;</a>', $page + 1 ); 
      }           
    }

    $pagerContainer .= '</div>';
?>

<div class="search-content">

    <h1>My Ticket</h1>
    <?php
        echo $pagerContainer;
        foreach($myTicket as $ticket){
    ?>
        <div class="column">
                <img src="../asset/event.jpg" alt="event" style="width:100%">
                <h1><?php echo $ticket['eventTitle'] ?></h1>
                <h3><?php echo "Date: $ticket[startDate]" ?></h3>
                <h3><?php echo "Venue: $ticket[venue] " ?></h3>
                <h3><?php echo "Ticket: $ticket[total_ticket]" ?></h3>
        </div>
    <?php
        };
    ?>

</div>