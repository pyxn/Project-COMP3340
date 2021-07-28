<?php

session_start();
unset($_SESSION['user']);
unset($_SESSION['color']);

header('location: status.php');

?>
