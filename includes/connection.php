<?php

$server     = "localhost";
$username   = "root";
$password   = ""; //root
$db         = "client_address_book";
    
// Create connection
$conn = mysqli_connect( $server, $username, $password, $db );

// Check connection
if( !$conn ) {
    die( "Connection failed: " . mysqli_connect_error() );
}

//echo "You are connected!";

?>