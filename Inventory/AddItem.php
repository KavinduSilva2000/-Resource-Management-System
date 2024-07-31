<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "min_project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetching input values
$ItemNo = trim(filter_input(INPUT_POST, "ItemNo"));
$ItemName = trim(filter_input(INPUT_POST, "ItemName"));
$Reorder = trim(filter_input(INPUT_POST, "reorder"));

// Inserting data into database
$sql = "INSERT INTO item (Item_Id, Item_name, Replishment) VALUES ('$ItemNo', '$ItemName', '$Reorder')";

if (mysqli_query($conn, $sql)) {
    // Redirect to success page if insertion is successful
    header("Location: AddNewItem.html");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
