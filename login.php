<?php
session_start();
include 'db.php';

if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}

/* 🔥 LOGIN SECURITY */
if(!isset($_SESSION['attempt'])){
    $_SESSION['attempt'] = 0;
}
if(!isset($_SESSION['lock_time'])){
    $_SESSION['lock_time'] = 0;
}

/* 🔥 CHECK LOCK */
if($_SESSION['attempt'] >= 3){
    $time_diff = time() - $_SESSION['lock_time'];

    if($time_diff < 300){ // 5 min lock
        $error = "Account locked! Try after 5 minutes";
    } else {
        $_SESSION['attempt'] = 0;
    }
}

if(isset($_POST['login']) && $_SESSION['attempt'] < 3){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $captcha_input = trim($_POST['captcha']);

    if(empty($captcha_input)){
        $error = "Captcha required";
    }
    elseif(!isset($_SESSION['captcha']) || $captcha_input !== $_SESSION['captcha']){
        $_SESSION['attempt']++;
        $_SESSION['lock_time'] = time();
        $error = "Captcha Wrong (Attempt ".$_SESSION['attempt']."/3)";
    }
    else{

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $admin = $result->fetch_assoc();

            if(password_verify($password, $admin['password'])){
                $_SESSION['admin'] = $username;

                // 🔥 RESET SECURITY
                $_SESSION['attempt'] = 0;
                unset($_SESSION['captcha']);

                header("Location: index.php");
                exit();
            } else {
                $_SESSION['attempt']++;
                $_SESSION['lock_time'] = time();
                $error = "Invalid Password (Attempt ".$_SESSION['attempt']."/3)";
            }
        } else {
            $_SESSION['attempt']++;
            $_SESSION['lock_time'] = time();
            $error = "Invalid Username (Attempt ".$_SESSION['attempt']."/3)";
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

<body class="login-page">

<form method="POST">
<h2>Secure Admin Login</h2>

<label>Username:</label>
<input type="text" name="username" required>

<label>Password:</label>
<input type="password" name="password" required>

<label>Enter Captcha:</label>

<div class="captcha-box">
<input type="text" name="captcha" placeholder="Enter Captcha" required>
<img src="captcha.php" id="captchaImg">
<button type="button" onclick="refreshCaptcha()">↻</button>
</div>

<br>

<button type="submit" name="login">Login</button>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

</form>

<script>
function refreshCaptcha(){
    document.getElementById("captchaImg").src = "captcha.php?" + Date.now();
}
</script>

</body>
</html>