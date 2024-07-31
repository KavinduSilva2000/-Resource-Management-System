<?php
    include "connection.php";

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
   <div class="search-bar">
   <form action="search_issue.php" method="get">
        <input type="text" placeholder="  Quick Search ... NIC" name="search">
        <!--<button type="submit" name="search_book"><i class="fas fa-search">Search</i></button>-->
        <input type="submit" value="Search" name="search_book">
        </from>
    </div>

	<div class="profile">
		<div class="dropdown">
			<header class="dropbtn"=>My Profile</header>
			<div class="dropdown-content">
	      		<a href="#">Notifications</a>
	      		<a href="#">Settings</a>
	      		<a href="#">Logout</a>
	    	</div>
		</div>
	</div>

    <div class="form-container">
  <form class="my-form">
    Issued Books
    <br>
    <br>
    <br>
  </form>
  
</div>

<table class="my-table">
  <thead>
    <tr>
      <th>User Name</th>
      <th>User id</th>
      <th>Book Name</th>
      <th>Book Id</th>
      <th>Author</th>
      <th>Category</th>
      <th>Year</th>
      <th>Issued Date</th>
      <th>Return</th>
    </tr>
  </thead>
  <tbody>
  <?php
      if(isset($_GET['search_book'])){
   
        $search_book_name=$_GET['search'];
        $search_query="SELECT nic,username,Book_Name,Book_Id,Author,ISBN,Category,Year,issued_date  FROM `issue_book` where nic like'%$search_book_name%'";
    
        $result_query=mysqli_query($conn,$search_query);
        $num_of_rows=mysqli_num_rows($result_query);
        if($num_of_rows==0){
            echo "<h2 class='text-center text-danger'>No result match. /h2>";
        }

       while($row = mysqli_fetch_assoc($result_query))
       {
        echo"<tr>
        <td>$row[username]</td>
        <td>$row[nic]</td>
        <td>$row[Book_Name]</td>
        <td>$row[Book_Id]</td>
        <td>$row[Author]</td>
        <td>$row[Category]</td>
        <td>$row[Year]</td>
        <td>$row[issued_date]</td>
        <td>
            <a class='' href='returnfunction.php?id=$row[Book_Id]'>Return</a>
        </td>

    
    </tr>";

       }
    }

    ?>
    <!--<tr>
      <td>Data 1</td>
      <td>Data 2</td>
      <td>Data 3</td>
      <td>Data 4</td>
      <td>Data 5</td>
      <td>Data 6</td>
      <td>Data 7</td>
      <td><button class="request-button">Return</button>       </td>
    </tr>
    <tr>
      <td>Data 1</td>
      <td>Data 2</td>
      <td>Data 3</td>
      <td>Data 4</td>
      <td>Data 5</td>
      <td>Data 6</td>
      <td>Data 7</td>
      <td><button class="request-button">Return</button>       </td>
    </tr>
    <tr>
        <td>Data 1</td>
        <td>Data 2</td>
        <td>Data 3</td>
        <td>Data 4</td>
        <td>Data 5</td>
        <td>Data 6</td>
        <td>Data 7</td>
      <td><button class="request-button">Return</button>       </td>
      </tr>-->
    <!-- Add more rows as needed -->
  </tbody>
</table>





   <section></section>
  </body>
</html>
