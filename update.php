<?php
include 'db.php';

$id = intval($_POST['id']);

$student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
$name       = mysqli_real_escape_string($conn, $_POST['name']);
$email      = mysqli_real_escape_string($conn, $_POST['email']);
$course     = mysqli_real_escape_string($conn, $_POST['course']);
$aadhaar    = mysqli_real_escape_string($conn, $_POST['aadhaar']);
$mobile     = mysqli_real_escape_string($conn, $_POST['mobile']);
$pincode    = mysqli_real_escape_string($conn, $_POST['pincode']);

$errors = [];

/* Validation */

if(strlen($mobile) != 10){
    $errors['mobile'] = "Mobile must be 10 digits";
}

if(strlen($aadhaar) != 12){
    $errors['aadhaar'] = "Aadhaar must be 12 digits";
}

if(strlen($pincode) != 6){
    $errors['pincode'] = "Pincode must be 6 digits";
}

if(empty($name)){
    $errors['name'] = "Name is required";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Invalid email";
}

/* Error Check */
if(!empty($errors)){
    include 'edit.php';
    exit();
}

/* Photo Upload */
$photo = $_FILES['photo']['name'];
$temp  = $_FILES['photo']['tmp_name'];

if(!empty($photo)){

    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    if(!in_array($ext,$allowed)){
        $errors['photo'] = "Only JPG, JPEG, PNG allowed";
        include 'edit.php';
        exit();
    }

    // unique name (important)
    $photo = time() . "_" . $photo;

    move_uploaded_file($temp, "uploads/".$photo);

    $query = "UPDATE student SET
        student_id='$student_id',
        name='$name',
        email='$email',
        course='$course',
        aadhaar='$aadhaar',
        mobile='$mobile',
        pincode='$pincode',
        photo='$photo'
        WHERE id=$id";

}else{

    $query = "UPDATE student SET
        student_id='$student_id',
        name='$name',
        email='$email',
        course='$course',
        aadhaar='$aadhaar',
        mobile='$mobile',
        pincode='$pincode'
        WHERE id=$id";
}

if(mysqli_query($conn,$query)){
    header("Location: students.php");
    exit();
}else{
    echo "Error: " . mysqli_error($conn);
}
?>