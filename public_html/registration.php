<?php

/**
 * ---------------------------------------------------------------------------------
 * SQL CONNECTION CREDENTIALS
 * ---------------------------------------------------------------------------------
 * Configure SQL Connection using configuration file in server
 * ---------------------------------------------------------------------------------
 */
$sql_configuration_array    = parse_ini_file("../../../../sql-config.ini", true);

// Test server config location
if ($_SERVER['SERVER_NAME'] == 'newcitybetterlife.com' || $_SERVER['HTTP_HOST'] == 'newcitybetterlife.com') {
    $sql_configuration_array    = parse_ini_file("../sql-config.ini", true);
}

$db_name                    = $sql_configuration_array['database']['database'];
$db_hostname                = $sql_configuration_array['database']['hostname'];
$db_username                = $sql_configuration_array['database']['username'];
$db_password                = $sql_configuration_array['database']['password'];

session_start();
# header('location:login.php');

$con = mysqli_connect($db_hostname, $db_username, $db_password);
if (!$con) {
    die("connection fail: " . mysqli_connect_error());
}

mysqli_select_db($con, $db_name);

$name = $_POST['user'];
$pass = $_POST['password'];

$s = "select * from users where username = '$name' ";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

if ($num == 1) {
    echo '<script>alert("Username already exist!")</script>';
    header('location:login.php');
} 
else if($name==""){
    echo '<script>alert("Please fill in username!")</script>';
    header('location:login.php');
}
else if($pass==""){
    echo '<script>alert("Please fill in password!")</script>';
    header('location:login.php');
}
else {
    $reg = "insert into users(username, password) values ('$name', '$pass')";
    mysqli_query($con, $reg);
    echo '<script>alert("Thank you for your registration!")</script>';

    // Auto-login on successful register
    echo "<form id='form-registration-login' method='POST' action='validation.php' hidden>";
    echo "    <input type='hidden' name='user' value='$name' hidden>";
    echo "    <input type='hidden' name='password' value='$pass' hidden>";
    echo "</form>";
    echo "<script type='text/javascript'>";
    echo "    document.getElementById('form-registration-login').submit();";
    echo "</script>";
}
