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
    echo "Username already exist!";
} else {
    $reg = "insert into users(username, password) values ('$name', '$pass')";
    mysqli_query($con, $reg);
    echo "Registration is done.";
}
