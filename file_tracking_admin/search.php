<?php 
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
    $keyword = trim(filter_input(INPUT_POST, "search"));

    // SQL query to fetch data
    $sql = "SELECT Record_Room_No, File_Name, File_Id, Cupboard_No, Rack_No, Docket_No, Position_at_Docket 
            FROM file 
            WHERE Record_Room_No LIKE '%$keyword%' 
               OR File_Name LIKE '%$keyword%' 
               OR Cupboard_No LIKE '%$keyword%' 
               OR File_Id LIKE '%$keyword%' 
               OR Rack_No LIKE '%$keyword%' 
               OR Docket_No LIKE '%$keyword%' 
               OR Year LIKE '%$keyword%'";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Display search results
    echo "<p style='font-size: 30px; text-align: center; margin: 0;'>Searching results for keyword <i style='font-weight:bold;'>$keyword</i></p><br /><br />";

    // Display table
    echo "<table style='font-size: 20px; margin: 0 auto;'> 
            <tr style='background-color: #01A58D; color: white;'>
                <th style='width:180px; padding:15px; border-radius: 10px;'>Record Room No</th>
                <th style='width:100px; padding:15px; border-radius: 10px;'>File Name</th>
                <th style='width:100px; padding:15px; border-radius: 10px;'>File Id</th>
                <th style='width:100px; padding:15px; border-radius: 10px;'>Cupboard No</th>
                <th style='width:100px; padding:15px; border-radius: 10px;'>Rack No</th>
                <th style='width:100px; padding:15px; border-radius: 10px;'>Docket No</th>
                <th style='width:100px; padding:15px; border-radius: 10px;'>Position at Docket</th>
            </tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td style='text-align: center;'>".$row["Record_Room_No"]."</td>
                    <td style='text-align: center;'>".$row["File_Name"]."</td>
                    <td style='text-align: center;'>".$row["File_Id"]."</td>
                    <td style='text-align: center;'>".$row["Cupboard_No"]."</td>
                    <td style='text-align: center;'>".$row["Rack_No"]."</td>
                    <td style='text-align: center;'>".$row["Docket_No"]."</td>
                    <td style='text-align: center;'>".$row["Position_at_Docket"]."</td>
                </tr>";
        }
    }

    echo "</table>";

    // Close connection
    mysqli_close($conn);
?>
