<?php
$conn = mysqli_connect("localhost", "root", "", "mydb");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>