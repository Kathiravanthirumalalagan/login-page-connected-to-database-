<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['contactNumber'])
session_destroy();
header("Location: index.php");
?>