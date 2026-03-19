<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $course     = mysqli_real_escape_string($conn, $_POST['course']);
    $aadhaar    = mysqli_real_escape_string($conn, $_POST['aadhaar']);
    $mobile     = mysqli_real_escape_string($conn, $_POST['mobile']);
    $pincode    = mysqli_real_escape_string($conn, $_POST['pincode']);

    $photo = "";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = time() . "_" . basename($_FILES['photo']['name']);
        $target = "uploads/" . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    }

    $query = "INSERT INTO student (student_id, name, email, course, aadhaar, mobile, pincode, photo)
              VALUES ('$student_id', '$name', '$email', '$course', '$aadhaar', '$mobile', '$pincode', '$photo')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>