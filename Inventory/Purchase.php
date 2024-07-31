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

  <!-- Search bar -->
  <div class="search-bar">
    <header>Purchase</header>
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

  <!-- Form -->
  <div class="form-container">
    <form class="my-form" action="PurchaseProcess.php" method="post">
      <div class="form-group">
        <label for="ItemName">Item Name</label>
        <select id="ItemName" name="ItemName">
            <option value="Item Name"> Select </option>
            <?php
              // Database connection parameters
              $servername = "localhost";
              $username = "root";
              $password = "";
              $database = "min_project";

              // Create connection
              $conn = new mysqli($servername, $username, $password, $database);

              // Check connection
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              
              // SQL query to fetch itemId and itemname from database
              $sql = "SELECT Item_Id, Item_Name FROM item";
              $result = $conn->query($sql);

              // Generate options based on database query results
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row["Item_Name"] . '">' . $row["Item_Name"] . '</option>';
                }
              } else {
                echo '<option value="">No items found</option>';
              }
              
              // Close database connection
              $conn->close();
            ?>
        </select>
      </div>

      <br />

      <div class="form-group">
        <label for="Quantity">Quantity</label>
        <input type="number" id="Quantity" name="Quantity" placeholder=" " min="0" required>
      </div>

      <br />

      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" placeholder=" " required>
      </div>

      <br />

      <div class="button-group">
        <button type="submit" id="btn-add">Add</button>
        <button type="reset" id="btn-clear">Clear</button>
      </div>
    </form>
  </div>

  <section></section>
</body>
</html>
