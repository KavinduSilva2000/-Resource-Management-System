<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nic'])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}

// Get the logged-in user's NIC
$loggedInNic = $_SESSION['nic'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accessType = $_POST['access'];

    // Fetch user permission from the database

    $stmt = $conn->prepare("SELECT * FROM permission WHERE nic = ?");
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $loggedInNic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
// user and admin pages based on the access type

        if ($accessType == 'library') 
        {
            $permission = $row['library_management'];
            handlePermission($permission, 'library_user/userhome.php', 'library_admin/managebook.php');
        } elseif ($accessType == 'inventory') {
            $permission = $row['inventory'];
            handlePermission($permission, 'inventory_user.php', 'Inventory/AddNewItem.html');
        } elseif ($accessType == 'file_tracking') {
            $permission = $row['file_tracking'];
            handlePermission($permission, 'file_tracking_user/index-main.html', 'file_tracking_admin/index-main.html');
        } else {
            echo "Invalid access type.";
        }
    } else {
        echo "No permissions found for the user.";
    }

    $stmt->close();
    $conn->close();
}

function handlePermission($permission, $userPage, $adminPage) {
    if ($permission == 'admin') {
        header("Location: $adminPage");
        exit();
    } elseif ($permission == 'user') {
        header("Location: $userPage");
        exit();
    } elseif ($permission == 'not_access') {
        echo "Sorry, you have no access to this system.";
    } else {
        echo "Invalid permission type.";
    }
}
?>
