<?php
session_start();

// hapus session
session_unset();
session_destroy();

// hapus cookie
setcookie("email", "", time() - 3600, "/");

header("Location: login.php");
exit;
?>