<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "min_project";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form input
$Docket = filter_input(INPUT_POST, "docket");
$Capacity = filter_input(INPUT_POST, "capacity");
$Cupboard = filter_input(INPUT_POST, "cupboardno");
$Rack = filter_input(INPUT_POST, "rackno");

// Check if the docket already exists
$sql_check_docket = "SELECT Docket_No FROM docket WHERE Docket_No = $Docket";
$result_check_docket = mysqli_query($conn, $sql_check_docket);

if (mysqli_num_rows($result_check_docket) == 1) {
    // Display error message if the docket already exists
    echo "<p style='color:darkred; font-weight:bold; font-size:18px; margin:30px;'>Error: The attempt to add the New Docket has failed.<br />Entered Docket number already exists.<br /><br /></p>";
    mysqli_close($conn);
    echo "<form action='index-AddDocket.html' method='post' style='margin:30px';> <input style='background-color:#01A58D; color:white; font-size:18px; border-radius: 8px;' type='submit' value='Go Back' /></form>";
} else {
    // Insert new docket if it doesn't exist
    $sql_insert_docket = "INSERT INTO docket (Docket_No, Size, Cupboard_No, Rack_No, Status) VALUES ($Docket, $Capacity, $Cupboard, $Rack, 1)";
    mysqli_query($conn, $sql_insert_docket);
    mysqli_close($conn);

    // Redirect to index page after adding the docket
    header('Refresh: 5; URL=index-AddDocket.html');
    echo "<p style='color:darkred; font-weight:bold; font-size:18px; margin:30px;'>The New Docket has been successfully added.</p>";
}
?>
