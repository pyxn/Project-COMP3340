<?php

require_once('./helpers/DatabaseHelper.php');

$sql_configuration_array    = parse_ini_file("../../../../sql-config.ini", true);

// Test server config location
if ($_SERVER['SERVER_NAME'] == 'newcitybetterlife.com' || $_SERVER['HTTP_HOST'] == 'newcitybetterlife.com') {
    $sql_configuration_array    = parse_ini_file("../sql-config.ini", true);
}

$db_name                    = $sql_configuration_array['database']['database'];
$db_hostname                = $sql_configuration_array['database']['hostname'];
$db_username                = $sql_configuration_array['database']['username'];
$db_password                = $sql_configuration_array['database']['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $database_helper = new DatabaseHelper($db_hostname, $db_name, $db_username, $db_password);

    $post_title = filter_var($_POST['system-notification-post-title'], FILTER_SANITIZE_STRING);
    $post_content = filter_var($_POST['system-notification-post-content'], FILTER_SANITIZE_STRING);
    $post_author = filter_var($_POST['system-notification-post-author'], FILTER_SANITIZE_STRING);

    if ($database_helper->is_this_table_created("admins") == false) {
        echo "Admin table is missing.<br>";
    }

    if ($database_helper->is_this_table_created("posts") == false) {
        echo "Post table is missing.<br>";
    }

    $database_helper->debug($post_title);
    $database_helper->debug($post_content);
    $database_helper->debug($post_author);

    // Auto return on complete
    // echo "<form id='form-favorite-return' method='GET' action='city.php' hidden>";
    // echo "    <input type='hidden' name='rk' value='$selected_city_rank' hidden>";
    // echo "</form>";
    // echo "<script type='text/javascript'>";
    // echo "    document.getElementById('form-favorite-return').submit();";
    // echo "</script>";
}
