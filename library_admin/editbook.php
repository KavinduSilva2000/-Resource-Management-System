<?php
    include "connection.php";

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['id'])){
            header("location:managebook.php");
            exit;
        }
        $id = $_GET['id'];
        $sql = "SELECT * FROM `book` WHERE Book_ID=$id";
        $result = $conn->query($sql);
        $row =$result->fetch_assoc();

      $Book_Name=$row['Book_Name'];
      $Book_Id=$row['Book_Id'];
      $Category=$row['Category'];
      $Year=$row['Year'];
      $Author=$row['Author'];
      $ISBN=$row['ISBN'];
      $Publication=$row['Publication'];
      $Status=$row['Status'];
    }
    else{
        $Book_Name=$_POST['Book_Name'];
      $Book_Id=$_POST['Book_Id'];
      $Category=$_POST['Category'];
      $Year=$_POST['Year'];
      $Author=$_POST['Author'];
      $ISBN=$_POST['ISBN'];
      $Publication=$_POST['Publication'];
      $Status=$_POST['Status'];

      $sql = "UPDATE `book`WHERE Book_ID=$id SET Book_Name='$Book_Name', Book_Id='$Book_Id', Category='$Category', Year='$Year', Author='$Author', ISBN='$ISBN', Publication='$Publication', Status='$Status'";
      $result = $conn->query($sql);
    }
?> 
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>INS DASHBOARD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  <body>
    <div class="sidebar">
	    <header>Admin Panel</header>
	    <ul>
         <li><a href="managebook.php">Manage Books</a></li>
         <li><a href="catagory.php">Manage Category</a></li>
         <li><a href="requestedbook.php">Requested Books</a></li>
	     <li><a href="issuedbook.php">Issued Books</a></li>
	     <li><a href="returnedbook.php">Returned Books</a></li>
	     <!--<li><a href="addfine.html">Add Fine</a></li>-->
	    </ul>
   </div>
   

	


<div class="form-container">
    <h2>Update Books</h2>
    <br><br>
  <form class="my-form" action="" method="post" enctype ="multipart/form-data">

    
    <label>Book Name: </label>
    <input type="text" name="Book_Name" value="<?php echo $Book_Name; ?>" required="required">
    <br>
    <label>Book Id: </label>
    <input type="text" name="Book_Id" value="<?php echo $Book_Id; ?>" required="required">
    <br>
    <label>Category: </label>
    <select  name="Category" value="<?php echo $Category; ?>" required="required">
        <option value="">Category</option>
        <?php 
              $selecet_query="Select * from `categories`";
              $result_query=mysqli_query($conn,$selecet_query);
              while($row=mysqli_fetch_assoc($result_query)){
                $category_title=$row['category_title'];
                $category_id=$row['category_id'];
                echo "<option value='$category_id'>$category_title</option>";
              }
        
        
        ?>
          
      	
    </select>
    <br>
    <label>Year: </label>
    <input type="text"  name="Year" value="<?php echo $Year; ?>">
    
    <br>
    <label>Author: </label>
    <input type="text"  name="Author" value="<?php echo $Author; ?>" required="required">
    <br>
    <label>ISBN: </label>
    <input type="text"  name="ISBN" value="<?php echo $ISBN; ?>">
    <br>
    <label>Publication: </label>
    <input type="text"  name="Publication" value="<?php echo $Publication; ?>">
    <br>
    <label>Status: </label>
    <input type="text"  name="Status" value="<?php echo $Status; ?>" required="required">
    <br>
    <!--<label>Book Image: </label>
    <input type="file" name="Book_Image" value="<?php echo $Book_Image; ?>">-->

    <button type="submit" name="submit">Update</button>
  </form>
  
</div>


  </body>
</html>