<?php
include 'db.php';

$id = $_POST['id'];

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$course = $_POST['course'];
$aadhaar = $_POST['aadhaar'];
$mobile = $_POST['mobile'];
$pincode = $_POST['pincode'];

$errors = [];

/* Validation */

if(strlen($mobile) != 10){
    $errors['mobile'] = "Mobile number must be 10 digits";
}

if(strlen($aadhaar) != 12){
    $errors['aadhaar'] = "Aadhaar number must be 12 digits";
}

if(strlen($pincode) != 6){
    $errors['pincode'] = "Pin code must be 6 digits";
}

if(empty($name)){
    $errors['name'] = "Name is required";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Invalid email";
}

/* ❌ Error Fix */
if(!empty($errors)){
    include 'edit.php'; // ✅ fixed
    exit();
}

/* Photo Upload */

$photo = $_FILES['photo']['name'];
$temp = $_FILES['photo']['tmp_name'];

if($photo != ""){

    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    if(!in_array($ext,$allowed)){
        $errors['photo'] = "Only JPG, JPEG, PNG allowed";
        include 'edit.php'; // ✅ fixed
        exit();
    }

    move_uploaded_file($temp,"uploads/".$photo);

    $query = "UPDATE student SET
    student_id='$student_id',
    name='$name',
    email='$email',
    course='$course',
    aadhaar='$aadhaar',
    mobile='$mobile',
    pincode='$pincode',
    photo='$photo'
    WHERE id='$id'";

}else{

    $query = "UPDATE student SET
    student_id='$student_id',
    name='$name',
    email='$email',
    course='$course',
    aadhaar='$aadhaar',
    mobile='$mobile',
    pincode='$pincode'
    WHERE id='$id'";
}

mysqli_query($conn,$query);

/* Success redirect */
header("Location: students.php"); // ✅ better UX
exit();
?>