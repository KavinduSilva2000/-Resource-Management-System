<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="Style_FileTracking.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="index-main.html">Add File</a></li>
      <li><a href="index-AddDocket.html">Add New Docket</a></li>
      <li><a href="Search.html">Search File</a></li>
      <li><a href="UpdateD.php">Update Docket</a></li>
       <li><a href="UpdateF.php">Update File</a></li>
       <!-- <li><a href="DeleteDocket.php">Dispose Docket</a></li> -->
    </ul>
  </div>

  <!-- Search bar -->
  <div class="search-bar">
    <header>Update File Details</header>
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
  <div class="form-container" id="doc">
    <form class="my-form" action="#" method="post" id="form-center">
      <div class="form-group2">
        <?php
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "min_project";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // SQL query to retrieve docket numbers
            $sql = "SELECT File_Id FROM file";
            $result = mysqli_query($conn,$sql);
            

            // Output the select element with options
            echo "<select name='FileId' id='FileId' >";
            echo "<option value=''>Select a File Id</option>";
            
            // Check if there are results
            if ($result->num_rows > 0) {
                // Loop through each row in the result set
                while ($row = $result->fetch_assoc()) {
                    // Output an option element for each docket number
                    echo "<option value='" . $row['File_Id'] . "'>" . $row['File_Id'] . "</option>";
                }
            } else {
                // Output a message if there are no results
                echo "<option value=''>No docket numbers found</option>";
            }
            
            echo "</select>";

        ?>
          
          <button  type="submit">Search</button>  
      </div>
    </form>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Database connection parameters
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "min_project";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $database);

      // Check connection
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $FID = filter_input(INPUT_POST, "FileId");

      $sql1 = "SELECT * FROM file WHERE File_Id = '$FID'";

      $result1 = mysqli_query($conn, $sql1);

      if ($result1->num_rows > 0) {
          $row1 = $result1->fetch_assoc();
  ?>
      <div class="form-container">
        
    <form class="my-form" action="UpdateFile.php" method="post">
      <div class="form-group">
          
         <input type="hidden" name="FID" value="<?php echo $FID; ?>"> 
          
        <label for="fileNo">File NO</label>
        <input type="text" id="fileNo" name="fileNo" value="<?php echo $row1['File_Id']?>";>
      </div>
      <br />
      <div class="form-group">
        <label for="fileName">File Name</label>
        <input type="text" id="fileName" name="fileName" value="<?php echo $row1['File_Name']?>";>
      </div>
      <br />
      <div class="form-group">
        <label for="minit">Number Of Minits Sheets</label>
        <input type="number" id="minit" name="minit" value="<?php echo $row1['No_Of_MinitSheets']?>";  min="0" required >
      </div>
      <br />
      <div class="form-group">
        <label for="year">File Opened Year</label>
        <input type="number" id="year" name="year" value="<?php echo $row1['Year']?>"; max="2155" required>
      </div>
      <br />
      <div class="form-group">
        <label for="cupboardno">Cupboard NO</label>
        <input type="number" id="cupboardno" name="cupboardno" value="<?php echo $row1['Cupboard_No']?>";>
      </div>
      <br />
      <div class="form-group">
        <label for="rackno">Rack NO</label>
        <input type="number" id="rackno" name="rackno" value="<?php echo $row1['Rack_No']?>";>
      </div>
      <br />
      <div class="form-group">
        <label for="docketno">Docket NO</label>
        <input type="number" id="docketno" name="docketno" value="<?php echo $row1['Docket_No']?>";>
      </div>    
      <br />
      <div class="button-group">
        <button type="submit" id="btn-add">Update</button>
      </div>
    </form>
      </div>
  <?php
      } else {
          echo "<div class='form-container'>No data found for the selected docket number.</div>";
      }

      // Close the database connection
      $conn->close();
  }
  ?>

</body>
</html>
