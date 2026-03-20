<?php
include 'db.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM student WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Profile</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div style="padding:30px;">

<h2>Student Profile</h2>

<img src="uploads/<?php echo $row['photo']; ?>" width="150"><br><br>

<p><b>Name:</b> <?php echo $row['name']; ?></p>
<p><b>Email:</b> <?php echo $row['email']; ?></p>
<p><b>Course:</b> <?php echo $row['course']; ?></p>
<p><b>Aadhaar:</b> <?php echo $row['aadhaar']; ?></p>
<p><b>Mobile:</b> <?php echo $row['mobile']; ?></p>
<p><b>Pin Code:</b> <?php echo $row['pincode']; ?></p>

<br>
<a href="students.php">⬅ Back</a>

</div>

</body>
</html>