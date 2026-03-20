<?php
include 'db.php';

$errors = $errors ?? [];

if(!isset($_GET['id']) && !isset($id)){
    die("Invalid ID");
}

/* ID fix */
$id = $_GET['id'] ?? $id;

/* Data fetch */
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

<input type="hidden" name="id" value="<?php echo $id; ?>">

<label>Student ID</label>
<input type="text" name="student_id" 
value="<?php echo $_POST['student_id'] ?? $row['student_id']; ?>">

<label>Name</label>
<input type="text" name="name" 
value="<?php echo $_POST['name'] ?? $row['name']; ?>">
<?php if(!empty($errors['name'])){ ?>
<div class="error"><?php echo $errors['name']; ?></div>
<?php } ?>

<label>Email</label>
<input type="text" name="email" 
value="<?php echo $_POST['email'] ?? $row['email']; ?>">
<?php if(!empty($errors['email'])){ ?>
<div class="error"><?php echo $errors['email']; ?></div>
<?php } ?>

<label>Course</label>
<input type="text" name="course" 
value="<?php echo $_POST['course'] ?? $row['course']; ?>">

<label>Aadhaar</label>
<input type="text" name="aadhaar" 
value="<?php echo $_POST['aadhaar'] ?? $row['aadhaar']; ?>">
<?php if(!empty($errors['aadhaar'])){ ?>
<div class="error"><?php echo $errors['aadhaar']; ?></div>
<?php } ?>

<label>Mobile</label>
<input type="text" name="mobile" 
value="<?php echo $_POST['mobile'] ?? $row['mobile']; ?>">
<?php if(!empty($errors['mobile'])){ ?>
<div class="error"><?php echo $errors['mobile']; ?></div>
<?php } ?>

<label>Pin Code</label>
<input type="text" name="pincode" 
value="<?php echo $_POST['pincode'] ?? $row['pincode']; ?>">
<?php if(!empty($errors['pincode'])){ ?>
<div class="error"><?php echo $errors['pincode']; ?></div>
<?php } ?>

<label>Photo</label>
<input type="file" name="photo">
<?php if(!empty($errors['photo'])){ ?>
<div class="error"><?php echo $errors['photo']; ?></div>
<?php } ?>

<br><br>

<button type="submit">Update Student</button>

</form>

</div>

</body>
</html>