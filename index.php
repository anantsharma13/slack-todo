
<?php

    // index.php listens to requests generate by the slash commands

    // set response header content type to JSON
    header('Content-Type: application/json'); 
    require_once('controller.php');
    
    // To add record in the schema with IST date and time
    date_default_timezone_set('Asia/Kolkata');
        
    $data = $_POST; // HTTP POST data 
    $todo = new TODO($data); // create object of TODO class
    $response = $todo->executes(); // "executes" function can process any slash command
    echo $response;

?>

