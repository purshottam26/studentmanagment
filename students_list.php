<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM student");
?>

<!DOCTYPE html>
<html>
<head>
<title>Full Student List</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="index.php">Dashboard</a>
<a href="students.php">Back</a>
</div>

<div class="content">

<h2 style="color:#000;">Full Student List</h2>

<table>
<tr>
<th>Student ID</th>
<th>Name</th>
<th>Email</th>
<th>Course</th>
<th>Aadhaar</th>
<th>Mobile</th>
<th>Pin Code</th>
<th>Photo</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['course']; ?></td>
<td><?php echo $row['aadhaar']; ?></td>
<td><?php echo $row['mobile']; ?></td>
<td><?php echo $row['pincode']; ?></td>

<td>
<?php if(!empty($row['photo'])){ ?>
<img src="uploads/<?php echo $row['photo']; ?>" width="50">
<?php } else { echo "No Photo"; } ?>
</td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>