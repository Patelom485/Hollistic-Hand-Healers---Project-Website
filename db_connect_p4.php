<?php
$servername = "sql1.njit.edu";
$username = "onp"; 
$password = "@Tisha#221904";
$dbname = "onp";  


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
