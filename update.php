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

/* Validation */

if(strlen($mobile) != 10){
echo "Mobile number must be 10 digits";
exit();
}

if(strlen($aadhaar) != 12){
$error_messag = "Aadhaar number must be 12 digits";
$redirect_url = "edit.php?id=$id&error=$error_messag";
header("Location: $redirect_url");
exit();
}

if(strlen($pincode) != 6){
echo "Pin code must be 6 digits";
exit();
}

/* Photo Upload */

$photo = $_FILES['photo']['name'];
$temp = $_FILES['photo']['tmp_name'];

if($photo != ""){

$allowed = ['jpg','jpeg','png'];
$ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

if(!in_array($ext,$allowed)){
echo "Only JPG, JPEG, PNG allowed";
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

header("Location:index.php");

?>