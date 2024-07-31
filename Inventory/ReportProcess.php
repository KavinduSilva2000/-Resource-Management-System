<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="StyleSheet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="AddNewItem.html">Add New Item</a></li>
      <li><a href="AddNewSection.php">Add New Section</a></li>
      <li><a href="Purchase.php">Purchased Item</a></li>
      <li><a href="Issue.php">Issue Item</a></li>
      <li><a href="ItemReport.php">Stock Balance</a></li>
    </ul>
  </div>

  <!-- Profile -->
  <div class="profile">
    <div class="dropdown">
      <header class="dropbtn">My Profile</header>
      <div class="dropdown-content">
        <a href="#">Settings</a>
        <a href="#">Logout</a>
        <a href="#">Profile</a>
      </div>
    </div>
  </div>

  <!-- Report Body -->
  <div class="reportBody">
    <div class="search-bar">
      <header>Item Report</header>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Database configuration
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

      // Trim whitespace from the search keyword
      $SelectedItem = trim(filter_input(INPUT_POST, "ItemName"));

      // Display search results header
      echo "<p style='font-size: 30px; text-align: center; margin: 0;'>Balance Report for <i style='font-weight:bold;'>$SelectedItem</i> item</p><br /><br />";

      // Display table header
      echo "<table style='font-size: 18px; margin: 0 auto;'> 
            <tr style='background-color: #01A58D; color: white;'>
              <th style='width:100px; padding:15px; border-radius: 10px;'>Item Id</th>
              <th style='width:100px; padding:15px; border-radius: 10px;'>Item Name</th>
              <th style='width:150px; padding:15px; border-radius: 10px;'>Current Balance</th>
              <th style='width:150px; padding:15px; border-radius: 10px;'>Replishment</th>
              <th style='width:150px; padding:15px; border-radius: 10px;'>Reorder Needed</th>
              <th style='width:150px; padding:15px; border-radius: 10px;'>Open Balance</th>
            </tr>";

      // SQL query based on user selection
      if ($SelectedItem == "All") {
        $sql = "SELECT * FROM item";
      } elseif ($SelectedItem == "ReorderNeeded") {
        $sql = "SELECT * FROM item WHERE ReorderNeeded = 1";
      } else {
        $sql = "SELECT * FROM item WHERE Item_Name='$SelectedItem'";
      }

      // Execute query
      $result = mysqli_query($conn, $sql);

      // Display results
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $reorder = $row["ReorderNeeded"] == 0 ? "No" : "Yes";
          echo "<tr style='height: 30px;'>
                  <td style='text-align: center;font-size:16px;'>" . $row["Item_Id"] . "</td>
                  <td style='text-align: center;font-size:16px;'>" . $row["Item_name"] . "</td>
                  <td style='text-align: center;font-size:16px;'>" . $row["CurrentBalance"] . "</td>
                  <td style='text-align: center;font-size:16px;'>" . $row["Replishment"] . "</td>
                  <td style='text-align: center; font-size: 16px;'>" . $reorder . "</td>
                  <td style='text-align: center;font-size:16px;'>" . $row["Open_Balance"] . "</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='6' style='text-align: center;'>No items found</td></tr>";
      }

      echo "</table>";

      // Close connection
      mysqli_close($conn);
    }
    ?>
  </div>

</body>
</html>
