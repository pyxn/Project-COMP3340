<?php

session_start();
session_destroy();

header('location: adminlogin_edituser.php');

?>