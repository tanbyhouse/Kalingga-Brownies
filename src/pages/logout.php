<?php
// unset all session variables.
$_SESSION = array();

session_destroy();

header('Location: index.php?page=login&loggedout=1');
exit();