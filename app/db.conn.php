<?php


// Database connection configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'chat_app_db';

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo "Connection Failed";
    exit(); // Exit if connection fails
}



