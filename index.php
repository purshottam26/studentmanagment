<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include 'db.php';

/* Dashboard Data */
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM student");
$total_data = mysqli_fetch_assoc($total_query);
$total_students = $total_data['total'];

$course_query = mysqli_query($conn, "SELECT COUNT(DISTINCT course) as total_courses FROM student");
$course_data = mysqli_fetch_assoc($course_query);
$total_courses = $course_data['total_courses'];

$recent_query = mysqli_query($conn, "SELECT name FROM student ORDER BY id DESC LIMIT 1");
$recent_data = mysqli_fetch_assoc($recent_query);
$recent_student = $recent_data ? $recent_data['name'] : "None";

/* Pagination */
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

if(isset($_GET['search']) && $_GET['search']!=""){

$search = mysqli_real_escape_string($conn,$_GET['search']);

$query = "SELECT * FROM student 
WHERE name LIKE '%$search%' 
OR email LIKE '%$search%' 
LIMIT $start, $limit";

}else{

$query = "SELECT * FROM student LIMIT $start, $limit";

}

$result = mysqli_query($conn,$query);

$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM student");
$count_data = mysqli_fetch_assoc($count_query);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main-container">

<!-- Sidebar -->
<div class="sidebar">
<h2>Admin Panel</h2>
<a href="index.php">Dashboard</a>
<a href="#students">Students</a>
<a href="logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">

<div class="topbar">
<h1>Student Management System</h1>
</div>

<!-- Dashboard -->
<div class="dashboard">

<div class="card">
<h3>Total Students</h3>
<p><?php echo $total_students; ?></p>
</div>

<div class="card">
<h3>Total Courses</h3>
<p><?php echo $total_courses; ?></p>
</div>

<div class="card">
<h3>Recently Added</h3>
<p><?php echo $recent_student; ?></p>
</div>

</div>

<hr>

<h2>Add Student</h2>

<form method="POST" action="insert.php" enctype="multipart/form-data">

<label>Student ID</label>
<input type="text" name="student_id" required>

<label>Name</label>
<input type="text" name="name" pattern="[A-Za-z ]+" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Course</label>
<input type="text" name="course" required>

<label>Aadhaar</label>
<input type="text" name="aadhaar" pattern="[0-9]{12}" maxlength="12" required>

<label>Mobile</label>
<input type="text" name="mobile" pattern="[0-9]{10}" maxlength="10" required>

<label>Pin Code</label>
<input type="text" name="pincode" pattern="[0-9]{6}" maxlength="6" required>

<label>Photo</label>
<input type="file" name="photo" accept="image/*">

<br><br>
<button type="submit">Add Student</button>

</form>

<h2 id="students">Student List</h2>

<a href="export.php" class="btn-export">Download Excel</a>

<br><br>

<form method="GET">
<input type="text" name="search" placeholder="Search by name or email"
value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
<button type="submit">Search</button>
</form>

<br>

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
<th>Action</th>
</tr>

<?php
$query = "SELECT * FROM student ORDER BY id DESC LIMIT $start,$limit";
$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){
?>

<tr>

<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['course']; ?></td>
<td><?php echo $row['aadhaar']; ?></td>
<td><?php echo $row['mobile']; ?></td>
<td><?php echo $row['pincode']; ?></td>

<td>
<?php
if(!empty($row['photo'])){
?>
<img src="uploads/<?php echo $row['photo']; ?>" width="50">
<?php
}else{
echo "No Photo";
}
?>
</td>

<td class="action-btn">
<a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a><br><br>
<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a><br><br>
<a href="documents.php?id=<?php echo $row['id']; ?>">Documents</a>
</td>

</tr>

<?php } ?>

</table>

<div style="margin-top:20px;">

<?php
for($i=1;$i<=$total_pages;$i++){
echo "<a href='?page=".$i."' style='padding:8px 12px;margin:3px;background:#667eea;color:white;border-radius:5px;text-decoration:none;'>".$i."</a>";
}
?>

</div>

<hr>

</div> <!-- content -->

</div> <!-- main-container -->

<script>
window.onload=function(){
if(localStorage.getItem("scroll")){
window.scrollTo(0,localStorage.getItem("scroll"));
}
}

window.onscroll=function(){
localStorage.setItem("scroll",window.scrollY);
}
</script>

</body>
</html>