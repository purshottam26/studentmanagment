<?php
include 'db.php';

// ID check (safe)
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
} else {
    echo "Invalid ID";
    exit();
}

// Data fetch
$result = mysqli_query($conn, "SELECT * FROM student WHERE id=$id");

if(mysqli_num_rows($result) == 0){
    echo "Student not found";
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Profile</title>
<link rel="stylesheet" href="style.css">
</head>

<!-- 🔥 IMPORTANT CLASS ADD KIYA -->
<body class="profile-page">

<div class="content">

    <div class="profile-container">
        <div class="profile-card">

            <h2>Student Profile</h2>

            <img src="uploads/<?php echo $row['photo']; ?>" class="profile-img" alt="Student Photo">

            <div class="profile-info">
                <p><span>Name:</span> <?php echo $row['name']; ?></p>
                <p><span>Email:</span> <?php echo $row['email']; ?></p>
                <p><span>Course:</span> <?php echo $row['course']; ?></p>
                <p><span>Aadhaar:</span> <?php echo $row['aadhaar']; ?></p>
                <p><span>Mobile:</span> <?php echo $row['mobile']; ?></p>
                <p><span>Pin Code:</span> <?php echo $row['pincode']; ?></p>
            </div>

            <a href="students.php" class="profile-back">⬅ Back</a>

        </div>
    </div>

</div>

</body>
</html>