<?php
// Unset all session variables.
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to the login page with a success message.
header('Location: index.php?page=login&loggedout=1');
exit();