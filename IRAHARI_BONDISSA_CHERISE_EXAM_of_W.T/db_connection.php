<?php
// Connection details
$host = "localhost";
$user = "Irahari";
$pass = "bondissa09";
$database = "online_agile_methodology_courses_platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>