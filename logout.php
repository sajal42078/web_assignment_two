<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page with message
header("Location: /travel-blog/admin/login.php?logout=1");
exit;
?>