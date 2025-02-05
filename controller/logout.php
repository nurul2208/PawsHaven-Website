<?php
// Start or resume the session
session_start();

// Destroy the session
session_destroy();

// Redirect to the home page or any other page after logout
header("location: http://localhost/Petshop11/dash.php");
exit();
?>
