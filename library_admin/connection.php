<?php

$servername = "localhost";
$username = "root";  
$password = "";  
$database = "min_project";

$conn = mysqli_connect($servername,$username,$password,$database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>