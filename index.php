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
        <a href="students.php">Students</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">

        <!-- Topbar -->
        <div class="topbar">
            <h1 style="color:#000;">Student Management System</h1>
        </div>

        <!-- Dashboard Cards -->
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

        <!-- Button -->
        <div class="btn-box" style="margin-bottom:20px;">
            <a href="students.php" class="btn" style="
                background:#667eea;
                color:white;
                padding:10px 15px;
                border-radius:6px;
                text-decoration:none;
            ">📋 Go to Student List</a>
        </div>

        <!-- Welcome Box -->
        <div class="welcome-box" style="
            background:white;
            padding:20px;
            border-radius:10px;
            max-width:500px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        ">
            <h2 style="color:#000;">Welcome</h2>
            <p style="color:#000;">
                This is your dashboard. Click on <b>Students</b> to manage students.
            </p>
        </div>

    </div>

</div>

</body>
</html>