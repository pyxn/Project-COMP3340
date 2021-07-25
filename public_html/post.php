<?php

session_start();

require_once('./helpers/DatabaseHelper.php');

$sql_configuration_array    = parse_ini_file("../../../../sql-config.ini", true);

if ($_SERVER['SERVER_NAME'] == 'newcitybetterlife.com' || $_SERVER['HTTP_HOST'] == 'newcitybetterlife.com') {
    $sql_configuration_array    = parse_ini_file("../sql-config.ini", true);
}

$db_name                    = $sql_configuration_array['database']['database'];
$db_hostname                = $sql_configuration_array['database']['hostname'];
$db_username                = $sql_configuration_array['database']['username'];
$db_password                = $sql_configuration_array['database']['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $database_helper = new DatabaseHelper($db_hostname, $db_name, $db_username, $db_password);

    if (isset($_POST['system-notification-create'])) {
        echo "CREATE DETECTED!";
        $admin_username = filter_var($_POST['system-notification-post-author'], FILTER_SANITIZE_STRING);
        $post_title = filter_var($_POST['system-notification-post-title'], FILTER_SANITIZE_STRING);
        $post_content = filter_var($_POST['system-notification-post-content'], FILTER_SANITIZE_STRING);

        if ($database_helper->is_this_table_created("posts") == false) {
            $database_helper->set("CREATE TABLE `posts` ( 
                `id` INT(32) NOT NULL AUTO_INCREMENT , 
                `username` VARCHAR(255) NOT NULL , 
                `post_title` TEXT NOT NULL , 
                `post_content` TEXT NOT NULL , 
                `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        }

        if ($database_helper->is_this_table_created("admins") == false) {
            $database_helper->set("CREATE TABLE `admins` (username VARCHAR(50) NOT NULL PRIMARY KEY, password VARCHAR(50) NOT NULL);");
        }

        $admin_presence = $database_helper->get("SELECT * FROM `admins` WHERE username = '$admin_username;");

        if (count($admin_presence) >= 0) {
            $database_helper->set("INSERT INTO posts (`id`, `username`, `post_title`, `post_content`, `timestamp`) VALUES (DEFAULT, '$admin_username', '$post_title', '$post_content', DEFAULT);");
        }
    } else if (isset($_POST['system-notification-delete'])) {
        echo "DELETE DETECTED!";
    }

    // header('Location: status.php', true, 301);
    // exit();
}
