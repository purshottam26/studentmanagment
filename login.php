<?php
session_start();
include 'db.php';

if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['login'])){

    // CAPTCHA CHECK
    if($_POST['captcha'] != $_SESSION['captcha']){
        $error = "Captcha Wrong";
    } else {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepared Statement
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $admin = $result->fetch_assoc();

            if(password_verify($password, $admin['password'])){
                $_SESSION['admin'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid Password";
            }
        } else {
            $error = "Invalid Username";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Secure Admin Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    
<form method="POST">
<h2>Secure Admin Login</h2>


<label>Username:</label>
<input type="text" name="username" required>

<label>Password:</label>
<input type="password" name="password" required>

<!-- 🔥 CAPTCHA -->
<label>Enter Captcha:</label>

<div class="captcha-box">

<input type="text" name="captcha" required style="width:200px;">

<img src="captcha.php" id="captchaImg" style="height:40px;">

<button type="button" onclick="refreshCaptcha()">↻</button>

</div>

<br>

<button type="submit" name="login">Login</button>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

</form>

<script>
function refreshCaptcha(){
    document.getElementById("captchaImg").src = "captcha.php?" + Date.now();
}
</script>

</body>
</html>