
<?php
include 'db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_list.xls");

echo "Student ID\tName\tEmail\tCourse\tAadhaar\tMobile\tPin Code\n";

$query = mysqli_query($conn,"SELECT * FROM student");

while($row = mysqli_fetch_assoc($query)){

echo $row['student_id']."\t".
     $row['name']."\t".
     $row['email']."\t".
     $row['course']."\t".
     $row['aadhaar no']."\t".
     $row['mobile no']."\t".
     $row['pincode']."\n";

}
?>
