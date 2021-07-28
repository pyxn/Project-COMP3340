<?php

$username=$_SESSION['username'];
session_start();
session_destroy();

session_start();
$_SESSION['username'] = $username;

header('location: status.php');

?>
