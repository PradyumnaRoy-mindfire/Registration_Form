<?php
$servername = "localhost";
$username = "root";
$password = "mindfire";

// Create connection
$conn = mysqli_connect($servername, $username, $password);


$dbname = "Form";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";  //query to create a database

//The mysqli_query() function in PHP executes an SQL query on a given MySQL database connection.
mysqli_query($conn, $sql);  

$conn = mysqli_connect($servername, $username, $password,$dbname);

//make email unique
$sql = "CREATE TABLE IF NOT EXISTS users (
    userId INT AUTO_INCREMENT PRIMARY KEY,  
    fname VARCHAR(50),
    lname VARCHAR(50),
    pass VARCHAR(100),
    phno VARCHAR(15),
    email VARCHAR(100), 
    gender VARCHAR(10),
    adress VARCHAR(255),
    pin VARCHAR(10),
    photo VARCHAR(255),
    terms BOOLEAN
);";

mysqli_query($conn,$sql);

$sql = "CREATE TABLE IF NOT EXISTS favourites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    favName VARCHAR(50),
    favItem VARCHAR(100),
    like_count INT DEFAULT 0,
    FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE   
);";


mysqli_query($conn,$sql);

// if (!$conn) {
//     die("Connection failed: " . $conn);
// } else {
//     echo "table created  successfully";
// }
//--on delete cascade delete the record if the parent data record is delete








?>