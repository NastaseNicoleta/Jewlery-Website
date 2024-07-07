<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

// Crează conexiunea
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifică conexiunea
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
