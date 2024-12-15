<?php

$host = 'localhost';
$db_name = 'dolphin_crm'; 
$xampp_username = 'root'; 
$xampp_password = ''; 

// Create connection
$conn = new mysqli($host, $xampp_username, $xampp_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";

?>