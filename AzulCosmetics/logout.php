<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data

// Redirect to login page
header("Location: astrogear-login.html");
exit();
?>