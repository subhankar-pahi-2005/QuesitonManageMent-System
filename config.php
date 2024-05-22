<?php
$servername = "localhost";
$username = "root"; // change this to your DB username
$password = ""; // change this to your DB password
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
