<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);

    // Query to get the user data
    $sql = "SELECT * FROM user WHERE username='$username' AND nic='$nic'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch user data
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, start the session
            $_SESSION['username'] = $username;
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['nic'] = $nic;

            // Redirect to the dashboard
            header("Location: welcome.html");
            exit();
        } else {
            // If password does not match, provide an error message
            echo "Invalid username or password.";
        }
    } else {
        // If username does not exist, provide an error message
        echo "Invalid username or password.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>