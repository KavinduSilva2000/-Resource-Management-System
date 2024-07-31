<?php

$servername = "localhost";
$username = "root";
$dbPassword = "";
$dbname = "min_project";

$conn = mysqli_connect($servername, $username, $dbPassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nic = $_POST['nic'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Check if NIC is longer than 7 digits
    if (strlen($nic) <= 7) {
        echo "NIC must be longer than 7 digits.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user details into the database
    $sql = "INSERT INTO user_temp (first_name, last_name, nic, password) VALUES ('$firstname', '$lastname', '$nic', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
