<?php
    include "connection.php";

    if(isset($_POST['submit'])){
      $category_title=$_POST['Book_Id'];

      //select data from database
      $select_query="Select * from `categories` where category_title='$category_title'";
      $result_select=mysqli_query($conn,$select_query);
      $number=mysqli_num_rows($result_select);
      if($number>0){
        echo "<script>alert('This category is present inside the database')</script>";
      }else{

      $insert_query="insert into `categories` (category_title) values ('$category_title') ";
      $result=mysqli_query($conn,$insert_query);
      if($result){
        echo "<script>alert('Category has been inserted successfully')</script>";
      }
    }

    }

    $query = "select * from `categories`";
    $result1=mysqli_query($conn,$query);

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
         <!--<li><a href="pendingrequest.php">Pending Request</a></li>-->
         <li><a href="requestedbook.php">Requested Books</a></li>
	     <li><a href="issuedbook.php">Issued Books</a></li>
	     <li><a href="returnedbook.php">Returned Books</a></li>
	     <!--<li><a href="addfine.html">Add Fine</a></li>
	     <li><a href="notification.html">Notification</a></li>-->
	    </ul>
   </div>
   

	


<div class="form-container">
    <h2>Add Catagory</h2>
    <br><br>
    <form class="my-form" action="" method="post">
    <input type="text" name="Book_Id" placeholder="Category">
    <br>
    
    <button type="submit" name="submit">Add</button>
  </form>
 
</div>
<br><br><br>



<div class="form-container">
    Remove Catagory
    <br><br>
</div>

<table class="my-table">
  
    
    <tr>
      
      <th>Category</th>
      <th>Remove</th>
    
    </tr>
  
    <tr>
    <?php

       while($row =mysqli_fetch_assoc($result1))
       {
        ?>
        <td><?php echo $row['category_title']; ?></td>
        <td><button class="remove-button">Remove</button>       </td>

   </tr>
        <?php

       }

    ?>
      
    
    <--<tr>
      <td>Data 1</td>
      <td><button class="remove-button">Remove</button>       </td>
      
    </tr>
    <tr>
        <td>Data 1</td>
        <td><button class="remove-button">Remove</button>       </td>
        
      </tr>-->



    <!-- Add more rows as needed -->
  </tbody>
</table>



   <section></section>
  </body>
</html>
