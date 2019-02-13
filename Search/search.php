<?php
    define("TITLE","Search | Event+");
    define("current","search");
    include('../includes/header.php');

    include('../includes/array.php');
  
    
    global $pagerContainer,$total;
    $events = $_SESSION['eventList'];
    $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
    if(is_array($events))
    {
        $total = count( $events); //total items in array  
        $limit = 3; //per page    
        $totalPages = ceil( $total/ $limit ); //calculate total pages
        $offset = ($page - 1) * $limit;
        if( $offset < 0 ) $offset = 0;
        $events = array_slice( $events, $offset, $limit );
        $link = 'search.php?page=%d';
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
    }
 
?>

<div class="search-content">
   
   <div class="search-container">
       <form action="../includes/array.php" method="post">
           <input type="search" name="searchTitle" class="search-bar" placeholder="Search An Event">
           <button type="submit" class="search-btn"><span>Search</span></button>
       </form>
       
   </div>

    <?php
    echo $pagerContainer;
    if($total <= 0){
        echo "<br> <h1 style='color:#040934;'>No result is found !</h1>";
    }
        if (is_array($events) || is_object($events))
        {
            foreach ($events as $event)
            {
    ?>
       <a href="../Event/event.php?event=<?php echo $event['eventId']; ?>"><div class="column">
                <img src="../asset/event.jpg" alt="event" style="width:100%">
                <h2><?php echo $event['eventTitle']; ?></h2>
                <p><?php echo $event['startDate']; ?></p>
                <p><?php echo $event['venue']; ?></p>
                <button class="register-btn">Register</button>
        </div></a>  
    <?php
            }
        };
    ?>
</div>