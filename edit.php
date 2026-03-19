
<?php
include 'db.php';

if(!isset($_GET['id'])){
    die("Invalid ID");
}

$id = $_GET['id'];

$query = "SELECT * FROM student WHERE id='$id'";
$result = mysqli_query($conn,$query);

$row = mysqli_fetch_assoc($result);

if(!$row){
    die("Student not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h2>Edit Student</h2>

<div class="edit-box">

<form method="POST" action="update.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<label>Student ID</label>
<input type="text" name="student_id" value="<?php echo $row['student_id']; ?>">

<label>Name</label>
<input type="text" name="name" value="<?php echo $row['name']; ?>">

<label>Email</label>
<input type="text" name="email" value="<?php echo $row['email']; ?>">

<label>Course</label>
<input type="text" name="course" value="<?php echo $row['course']; ?>">

<label>Aadhaar</label>
<input type="text" name="aadhaar" value="<?php echo $row['aadhaar']; ?>">

<label>Mobile</label>
<input type="text" name="mobile" value="<?php echo $row['mobile']; ?>">

<label>Pin Code</label>
<input type="text" name="pincode" value="<?php echo $row['pincode']; ?>">

<label>Photo</label>
<input type="file" name="photo">

<br><br>

<button type="submit">Update Student</button>

</form>

</div>

</body>
</html>
