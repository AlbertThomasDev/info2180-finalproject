<?php

$host = 'localhost';
$db_name = 'dolphin_crm'; 
$xampp_username = 'root'; 
$xampp_password = ''; 

// Create connection
try{
$conn = new PDO("mysql:host=$host;dbname=$db_name", $xampp_username, $xampp_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check connection
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



?>