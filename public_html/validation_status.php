<!-- Duplicated from validation_editrecord.php and validation_edituser.php -->
<?php

// This is a script to validate an administrator login
session_start();

// Connect to the database
$con = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
if (!$con) {
    die("connection fail: " . mysqli_connect_error());
}

mysqli_select_db($con, 'qiao6_comp3340');

// Obtain submitted admin credentials
$name = $_POST['username'];
$pass = $_POST['password'];

// Find the admin with the same credentials
$s = "select * from admins where username = '$name' && password = '$pass' ";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

// If the admin exists, log them in
// If not, display an login error message
if ($num == 1) {
    $_SESSION['user'] = $name;
    header('location:status.php');
} else {
    echo '<script>if(!alert("Incorrect username or password. Try again!")) document.location = "adminlogin_status.php";</script>';
}

?>