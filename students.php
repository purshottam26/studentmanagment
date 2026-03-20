<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include 'db.php';

/* 🔥 Graph Data */
$graph_query = mysqli_query($conn, "SELECT course, COUNT(*) as total FROM student GROUP BY course");

$course_names = [];
$course_counts = [];

while($row = mysqli_fetch_assoc($graph_query)){
    $course_names[] = $row['course'];
    $course_counts[] = $row['total'];
}

/* Pagination */
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

/* Search */
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

/* Count */
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM student");
$count_data = mysqli_fetch_assoc($count_query);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Students</title>
<link rel="stylesheet" href="style.css">

<!-- 🔥 Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<div class="main-container">

<!-- Sidebar -->
<div class="sidebar">
<h2>Admin Panel</h2>
<a href="index.php">Dashboard</a>
<a href="students.php">Students</a>
<a href="logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">

<div class="topbar">
<h1>Students Management</h1>
</div>

<!-- 🔥 GRAPH SECTION -->
<div style="background:white; padding:20px; border-radius:10px; margin-bottom:20px;">
<h2 style="color:black;">Students Per Course</h2>
<canvas id="myChart"></canvas>
</div>

<!-- Add Student -->

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

<hr>

<!-- Student List -->

<h2>Student List</h2>

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

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['student_id']; ?></td>

<td>
<a href="profile.php?id=<?php echo $row['id']; ?>" style="color:#667eea; font-weight:bold;">
<?php echo $row['name']; ?>
</a>
</td>

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

<td class="action-btn">
<a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a><br><br>
<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a><br><br>
<a href="documents.php?id=<?php echo $row['id']; ?>">Documents</a>
</td>

</tr>

<?php } ?>

</table>

<!-- Pagination -->

<div style="margin-top:20px;">

<?php
for($i=1;$i<=$total_pages;$i++){
echo "<a href='?page=".$i."' style='padding:8px 12px;margin:3px;background:#667eea;color:white;border-radius:5px;text-decoration:none;'>".$i."</a>";
}
?>

</div>

</div>
</div>

<!-- 🔥 GRAPH SCRIPT -->
<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($course_names); ?>,
        datasets: [{
            label: 'Students',
            data: <?php echo json_encode($course_counts); ?>,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>