<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Only start session if not already started
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>