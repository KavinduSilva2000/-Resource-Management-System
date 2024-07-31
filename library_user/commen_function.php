<?php
// Including connection file
include "connection.php";

// Getting books
function getbooks(){
    global $conn;

    // Condition to check isset or not
    if(!isset($_GET['catsearch'])){
        $select_query="SELECT * FROM `book` ORDER BY rand() LIMIT 0,12";
        $result_query=mysqli_query($conn, $select_query);

        while($row = mysqli_fetch_assoc($result_query)){
            $Book_Image = $row['Book_Image'];
            $Book_Name = $row['Book_Name'];
            $Book_Id = $row['Book_Id'];

            echo "<div class='product'>
                    <a href='book_details.php?Book_Id=$Book_Id'>
                        <img src='../library_admin/bookimage/$Book_Image' alt=''>
                        <h3>$Book_Name</h3>
                    </a>
                  </div>";
        }
    }
}

//getting all books
function get_all_books(){
    global $conn;

    //condition to check isset or not
    if(!isset($_GET['catsearch'])){

    $select_query="Select * from `book` order by rand()";
    $result_query=mysqli_query($conn,$select_query);


    while($row=mysqli_fetch_assoc($result_query)){
        $Book_Image=$row['Book_Image'];
        $Book_Name=$row['Book_Name'];
        $Book_Id=$row['Book_Id'];

        echo"<div class='product' >
        <a href='book_details.php?Book_Id=$Book_Id'>
                <img src='../library_admin/bookimage/$Book_Image' alt=''>
                <h3>$Book_Name</h3>
            </div>";

    }
}
}

//getting unique categories

function get_unique_categories(){
    global $conn;

    if(isset($_GET['search_category'])){
    $search_category=$_GET['Category'];
    $search_query="Select * from `book` where Category=$category_title";
    $result_query=mysqli_query($conn,$search_cat_query);


    while($row=mysqli_fetch_assoc($result_query)){
        $Book_Image=$row['Book_Image'];
        $Book_Name=$row['Book_Name'];
        $Book_Id=$row['Book_Id'];

        echo"<div class='product' >
        <a href='book_details.php?Book_Id=$Book_Id'>
                <img src='../library_admin/bookimage/$Book_Image' alt=''>
                <h3>$Book_Name</h3>
                
            </div>";

    }
}
}



// searching books function 

function search_books(){

    global $conn;
    if(isset($_GET['search_book_data'])){
       
        $search_book_name=$_GET['search_books'];
        $search_query="Select * from `book` where Book_Name like'%$search_book_name%'";

        $result_query=mysqli_query($conn,$search_query);
        $num_of_rows=mysqli_num_rows($result_query);
        if($num_of_rows==0){
            echo "<h2 class='text-center text-danger'>No result match. This Book is not available</h2>";
        }


        while($row=mysqli_fetch_assoc($result_query)){
            $Book_Image=$row['Book_Image'];
            $Book_Name=$row['Book_Name'];
            $Book_Id=$row['Book_Id'];

            echo"<div class='product' >
            <a href='book_details.php?Book_Id=$Book_Id'>
                    <img src='../library_admin/bookimage/$Book_Image' alt=''>
                    <h3>$Book_Name</h3>
                </div>";

        }
    }
}


// Function to view details
function view_details(){
    global $conn;

    // Condition to check isset or not
    if(isset($_GET['Book_Id'])){
        $product_id = $_GET['Book_Id'];
        $select_query = "SELECT * FROM book WHERE Book_Id = $product_id";
        $result_query = mysqli_query($conn, $select_query);

        while($row = mysqli_fetch_assoc($result_query)){
            $Book_Image = $row['Book_Image'];
            $Book_Name = $row['Book_Name'];
            $Book_Id = $row['Book_Id'];
            $Category = $row['Category'];
            $Year = $row['Year'];
            $Author = $row['Author'];
            $ISBN = $row['ISBN'];
            $Status = $row['Status'];

            echo "<div class='col-md-6'>
                    <img src='../library_admin/bookimage/$Book_Image' alt='' class='img-fluid' style='margin: 20px 10px; border-radius: 10px;'>
                  </div>
                  <div class='col-md-6'>
                    <h1 class='display-6'>$Book_Name</h1>
                    <p class='lead'></p>
                    <hr class='my-4'>
                    <h4>Book Details</h4>
                    <ul class='list-unstyled'>
                        <li><strong>Book Name:</strong> $Book_Name</li>
                        <li><strong>Book ID:</strong> $Book_Id</li>
                        <li><strong>ISBN:</strong> $ISBN</li>
                        <li><strong>Category:</strong> $Category</li>
                        <li><strong>Year:</strong> $Year</li>
                        <li><strong>Author:</strong> $Author</li>
                    </ul>";

                    // Check if the book is currently requested by another user
            $request_query = "SELECT * FROM request_book WHERE Book_Id = $Book_Id";
            $request_result = mysqli_query($conn, $request_query);

            if (mysqli_num_rows($request_result) > 0) {
                echo "<p class='text-warning'>This book is currently requested by another user.</p>";
            } else {
                // Check if the book is currently borrowed by another user
                $issue_query = "SELECT * FROM issue_book WHERE Book_Id = $Book_Id";
                $issue_result = mysqli_query($conn, $issue_query);

                if (mysqli_num_rows($issue_result) > 0) {
                    echo "<p class='text-warning'>This book is currently borrowed by another user.</p>";
                } else{

            if ($Status == 'Borrow') {
                echo "<form action='request_book.php' method='post'>
                        <input type='hidden' name='book_id' value='$Book_Id'>
                        <input type='hidden' name='isbn' value='$ISBN'>
                        <input type='hidden' name='book_name' value='$Book_Name'>
                        <input type='hidden' name='author' value='$Author'>
                        <input type='hidden' name='year' value='$Year'>
                        <input type='hidden' name='category' value='$Category'>
                        <button type='submit' class='btn btn-success btn-lg mt-3'>Request</button>
                        
                      </form>";
                    } else if ($Status == 'Library Use Only') {
                        echo "<p class='text-danger'>This book cannot be borrowed, Reference Only.</p>";
                    }
                }
            }

            echo "
            <form action='userhome.php'>
            <button type='submit' class='btn btn-danger btn-lg mt-3'>Cancel</button>
            </form>
                  </div>";
        }
    }
}

?>
