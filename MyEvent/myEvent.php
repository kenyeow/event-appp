<?php
    define("TITLE","Search | Event+");
    define("current","myEvent");
    include('../includes/header.php');
    

    $events = $_SESSION['eventList'];

    $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
    $total = count( $events); //total items in array    
    $limit = 3; //per page    
    $totalPages = ceil( $total/ $limit ); //calculate total pages
    
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;
    $events = array_slice( $events, $offset, $limit );
    $link = 'myEvent.php?page=%d';
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

    <h1>My Event</h1>
    <?php
        echo $pagerContainer;
        foreach($events as $event){
    ?>
       <a href="../EditEvent/editEvent.php?event=<?php echo $event['eventId']; ?>"> <div class="column">
                <img src="../asset/event.jpg" alt="event" style="width:100%">
                <h1><?php echo $event['eventTitle'] ?></h1>
                <h3><?php echo "Date: $event[startDate]" ?></h3>
                <h3><?php echo "Venue: $event[venue]" ?></h3>
                <button class="register-btn">Edit</button>
        </div></a>  
    <?php
        };
    ?>

</div>