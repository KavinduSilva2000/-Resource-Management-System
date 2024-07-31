<?php
    include "connection.php";
    include "commen_function.php";

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<nav class="navbar">
    <div class="left">
        <a href="userhome.php" class="navbar-link">Home Page</a>
        <a href="all_books.php" class="navbar-link">Books</a>
        <a href="requestlist.html" class="navbar-link">Request Book</a>
    </div>
    <div class="middle" >
        <form  action="search_books.php" method="get">
        <input type="search" placeholder="Search Books..." arial-label="Search"class="search-bar" name="search_books">
        <input type="submit" value="Search" name="search_book_data">
</form>
    </div>
    <div class="right">
        <a href="#" class="navbar-link">Profile</a>
    </div>
</nav>
        

<div class="content" method="get">
    <div class="left-content">
      <p class="greeting">Good Morning!</p>
      <p class="description">Discover your favorite books.</p>
    </div>


          
      	
    
  </div>
    <div class="container bg-light" style="margin-top: 20px; border-radius: 10px;">
        <div class="row">
        <?php 
        //calling function
        view_details();
            

        
        ?>

           <!-- <div class="col-md-6">
                <img src="img/Dune1.png" alt="Product Image" class="img-fluid" style="margin: 20px 10px ; border-radius: 10px;">
            </div>


            <div class="col-md-6">
                <h1 class="display-6">Dune Part 1</h1>
                <p class="lead">Paul Atreides arrives on Arrakis after his father accepts the stewardship of the dangerous planet. However, chaos ensues after a betrayal as forces clash to control melange, a precious resource.</p>

                <hr class="my-4">
                
                <h4>Book Details</h4>
                <ul class="list-unstyled">
                    <li><strong>Book Name:</strong> Dune 1</li>
                    <li><strong>Book ID:</strong> 00541NV</li>
                    <li><strong>ISBN:</strong> 85454181</li>
                    <li><strong>Category:</strong> Novel</li>
                </ul>
                <button type="button" class="btn btn-success btn-lg mt-3">Request</button>
                <button type="button" class="btn btn-danger btn-lg mt-3">Cancel</button>
            </div>-->
        </div>
    </div>
</body>
</html>
