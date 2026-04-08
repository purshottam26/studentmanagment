<?php
include "db.php";

$student_id = $_GET['id'];

$months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

$folder = "uploads/".$student_id."/";

if(!file_exists($folder)){
mkdir($folder,0777,true);
}

/* 🔥 DELETE FILE */
if(isset($_GET['delete'])){
$file = $_GET['delete'];
$file_path = $folder.$file;

if(file_exists($file_path)){
unlink($file_path);
}
header("Location: documents.php?id=".$student_id);
exit();
}

/* Upload */
if(isset($_POST['upload'])){

$month = $_POST['month'];

if($_FILES['salary']['name']!=""){
$name = $month."_salary_".$_FILES['salary']['name'];
move_uploaded_file($_FILES['salary']['tmp_name'],$folder.$name);
}

if($_FILES['bank']['name']!=""){
$name = $month."_bank_".$_FILES['bank']['name'];
move_uploaded_file($_FILES['bank']['tmp_name'],$folder.$name);
}

if($_FILES['report']['name']!=""){
$name = $month."_report_".$_FILES['report']['name'];
move_uploaded_file($_FILES['report']['tmp_name'],$folder.$name);
}

if($_FILES['attendance']['name']!=""){
$name = $month."_attendance_".$_FILES['attendance']['name'];
move_uploaded_file($_FILES['attendance']['tmp_name'],$folder.$name);
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Documents</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main-container">

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="index.php">Dashboard</a>
<a href="students.php">Students</a>
<a href="logout.php">Logout</a>
</div>

<div class="content">

<div class="topbar">
<h1>Student Documents</h1>
</div>

<h2>Upload Documents</h2>

<div class="form-box">
<form method="POST" enctype="multipart/form-data">

<select name="month">
<?php foreach($months as $m){ ?>
<option value="<?php echo $m; ?>"><?php echo $m; ?></option>
<?php } ?>
</select>

<br><br>

<label>Salary Slip</label>
<input type="file" name="salary">

<label>Bank Statement</label>
<input type="file" name="bank">

<label>Monthly Report</label>
<input type="file" name="report">

<label>Attendance</label>
<input type="file" name="attendance">

<br><br>

<button name="upload">Upload Documents</button>

</form>
</div>

<hr>

<h2>Month Wise Documents</h2>

<table>

<tr>
<th>Month</th>
<th>Salary</th>
<th>Bank</th>
<th>Report</th>
<th>Attendance</th>
</tr>

<?php

foreach($months as $month){

$salary="❌";
$bank="❌";
$report="❌";
$attendance="❌";

$files = scandir($folder);

foreach($files as $file){

if(strpos($file,$month."_salary")===0){
$salary="<a href='#' onclick=\"openPreview('$folder$file')\">View</a> 
<a href='?id=$student_id&delete=$file' style='color:red;'>Delete</a>";
}

if(strpos($file,$month."_bank")===0){
$bank="<a href='#' onclick=\"openPreview('$folder$file')\">View</a> 
<a href='?id=$student_id&delete=$file' style='color:red;'>Delete</a>";
}

if(strpos($file,$month."_report")===0){
$report="<a href='#' onclick=\"openPreview('$folder$file')\">View</a> 
<a href='?id=$student_id&delete=$file' style='color:red;'>Delete</a>";
}

if(strpos($file,$month."_attendance")===0){
$attendance="<a href='#' onclick=\"openPreview('$folder$file')\">View</a> 
<a href='?id=$student_id&delete=$file' style='color:red;'>Delete</a>";
}

}

echo "<tr>
<td>$month</td>
<td>$salary</td>
<td>$bank</td>
<td>$report</td>
<td>$attendance</td>
</tr>";

}

?>

</table>

</div>
</div>

<!-- 🔥 PREVIEW MODAL -->
<div id="previewModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.9); z-index:9999; justify-content:center; align-items:center;">
    
    <span onclick="closePreview()" style="position:absolute; top:20px; right:30px; color:white; font-size:30px; cursor:pointer;">✖</span>
    
    <img id="previewImage" style="max-width:90%; max-height:90%; border-radius:10px;">
</div>

<script>
function openPreview(src){
    document.getElementById("previewModal").style.display="flex";
    document.getElementById("previewImage").src = src;
}

function closePreview(){
    document.getElementById("previewModal").style.display="none";
}
</script>

</body>
</html>