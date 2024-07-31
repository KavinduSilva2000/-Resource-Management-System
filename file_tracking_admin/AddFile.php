<?php 
    
IF($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";  
    $password = "";  
    $database = "min_project";

    $conn = mysqli_connect($servername,$username,$password,$database);
   
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
   
    $FNo = trim( filter_input(INPUT_POST, "fileNo"));
    $FName = trim( filter_input(INPUT_POST, "fileName"));
    $Minit = trim( filter_input(INPUT_POST, "minit"));
    $Year = trim( filter_input(INPUT_POST, "year"));
    $Cupboard = trim( filter_input(INPUT_POST, "cupboardno"));
    $Rack = trim( filter_input(INPUT_POST, "rackno"));
    $Docket = trim( filter_input(INPUT_POST, "docketno"));
    
    // Start transection for esure the completeness of activety  
    mysqli_begin_transaction($conn);
    
    //Lock the Table for avoid concurrent activities 
  //  mysqli_query($conn,"LOCK TABLES file write");
 //   mysqli_query($conn,"LOCK TABLES docket write");
    
    // Check the docket already exists   
    $sql =  "SELECT Cupboard_No,Rack_No FROM docket WHERE Docket_No = $Docket";
    
    $result = mysqli_query($conn,$sql);
  
    if(mysqli_num_rows($result)==1){
        
        $row = mysqli_fetch_assoc($result);
        if( $Cupboard != $row["Cupboard_No"]  || $Rack != $row["Rack_No"] ){
            echo ("<p style='color:darkred; font-weight:bold; font-size:18px; margin:30px;'>Erro : The attempt to add the file has failed <br />Cupboard number or Rack No is mismatch with Docket number <br /><br /></p>");            
            mysqli_close($conn);
            echo "<form action='index-main.html' method='post' style='margin:30px';> <input style='background-color:#01A58D; color:white; font-size:18px; border-radius: 8px;' type='submit' value='Go Back' /></form>";
            die();
        }   
    }
    
    else{
        $sql2 = "INSERT INTO docket (Docket_No,Cupboard_No,Rack_No,Status) VALUES ($Docket,$Cupboard,$Rack,1)\n\n";
        mysqli_query($conn,$sql2);     
    }
  
   $sql1 = "INSERT INTO file (File_Id,File_Name,No_Of_MinitSheets,Year,Cupboard_No,Rack_No,Docket_No)VALUES ('$FNo','$FName',$Minit,$Year,$Cupboard,$Rack,$Docket)";

    if(mysqli_query($conn,$sql1)){
        mysqli_commit($conn);
        mysqli_close($conn);
        header("Location: index-main.html");        
    }

    else{
        mysqli_commit($conn);
        mysqli_close($conn);
        echo "Error: " . $sql1. "<br>" . mysqli_error($conn);        
    }  
   
    mysqli_query("UNLOCK TABLES");
    
}
?>