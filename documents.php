<?php
include "db.php";

$student_id = $_GET['id'];

$months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

$folder = "uploads/".$student_id."/";

if(!file_exists($folder)){
mkdir($folder,0777,true);
}

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

<div class="upload-box">

<h2>Upload Documents</h2>

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

<button name="upload" class="upload-btn">Upload Documents</button>

</form>

<hr>

<h2>Month Wise Documents</h2>

<table class="doc-table">

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
$salary="<a href='$folder$file' target='_blank'>View</a>";
}

if(strpos($file,$month."_bank")===0){
$bank="<a href='$folder$file' target='_blank'>View</a>";
}

if(strpos($file,$month."_report")===0){
$report="<a href='$folder$file' target='_blank'>View</a>";
}

if(strpos($file,$month."_attendance")===0){
$attendance="<a href='$folder$file' target='_blank'>View</a>";
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

</body>
</html>