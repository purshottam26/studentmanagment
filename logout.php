<a href="logout.php" style="float:right; background:red; padding:8px 12px; border-radius:6px; color:white; text-decoration:none;">
Logout
</a>
<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>