<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared Statement (SQL Injection Safe)
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $admin = $result->fetch_assoc();

        // Encrypted Password Verify
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Secure Admin Login</h2>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>

    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>

</body>
</html>