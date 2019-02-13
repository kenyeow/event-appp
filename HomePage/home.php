<?php

    define("TITLE","Home | Event+");
    define("current","home");
    include('../includes/header.php');

    $_SESSION['eventList'] ="";
                     
?>
        
     <div class="content">
        <h1>Find Your Next Experience</h1>
         <form action="../includes/array.php" method="post">
             <label>
                 <input name="searchTitle" type="search" placeholder="Search An Event">
             </label>
			 <button type="submit" class="searchBtn"><span>Search</span></button>
         </form>
         
    </div>

    
