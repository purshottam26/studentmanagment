<?php
include 'db.php';

$id = $_GET['id'];

$query = "DELETE FROM student WHERE id=$id";

if(mysqli_query($conn,$query)){
    header("Location: index.php");
    exit();
} else {
    echo mysqli_error($conn);
}
?>