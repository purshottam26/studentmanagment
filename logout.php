<?php
session_start();      // session start
session_unset();      // saare session remove
session_destroy();    // session destroy

header("Location: login.php"); // login page par redirect
exit();
?>