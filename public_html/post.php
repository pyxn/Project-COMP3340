<?php


// This is a script to create and delete system notification posts created by admin accounts

session_start();

require_once('./helpers/DatabaseHelper.php');

// MAIN SERVER: Extract configuration items from hidden configuration file
$sql_configuration_array    = parse_ini_file("../../../../sql-config.ini", true);

// TEST SERVER: Extract configuration items from hidden configuration file
if ($_SERVER['SERVER_NAME'] == 'newcitybetterlife.com' || $_SERVER['HTTP_HOST'] == 'newcitybetterlife.com') {
    $sql_configuration_array    = parse_ini_file("../sql-config.ini", true);
}

// Extract indivudal variables from parsed array
$db_name                    = $sql_configuration_array['database']['database'];
$db_hostname                = $sql_configuration_array['database']['hostname'];
$db_username                = $sql_configuration_array['database']['username'];
$db_password                = $sql_configuration_array['database']['password'];

// Execute script on post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Connect to database
    $database_helper = new DatabaseHelper($db_hostname, $db_name, $db_username, $db_password);

    // Logic to create a notification
    if (isset($_POST['system-notification-create'])) {
        /// --------------------------------
        /// DETECT A POST CREATION REQUEST
        /// --------------------------------
        // Clean the data
        $admin_username = filter_var($_POST['system-notification-post-author'], FILTER_SANITIZE_STRING);
        $post_title = filter_var($_POST['system-notification-post-title'], FILTER_SANITIZE_STRING);
        $post_content = filter_var($_POST['system-notification-post-content'], FILTER_SANITIZE_STRING);

        // Create posts table if it doesn't exist
        if ($database_helper->is_this_table_created("posts") == false) {
            $database_helper->set("CREATE TABLE `posts` ( 
                `id` INT(32) NOT NULL AUTO_INCREMENT , 
                `username` VARCHAR(255) NOT NULL , 
                `post_title` TEXT NOT NULL , 
                `post_content` TEXT NOT NULL , 
                `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        }

        // Create admin table if it doesn't exist
        if ($database_helper->is_this_table_created("admins") == false) {
            $database_helper->set("CREATE TABLE `admins` (username VARCHAR(50) NOT NULL PRIMARY KEY, password VARCHAR(50) NOT NULL);");
        }

        // Check if logged in user is an admin
        $admin_presence = $database_helper->get("SELECT * FROM admins WHERE username = '$admin_username';");

        // If it is an admin, create a new post
        if (count($admin_presence) >= 0) {
            $database_helper->set("INSERT INTO posts (`id`, `username`, `post_title`, `post_content`, `timestamp`) VALUES (DEFAULT, '$admin_username', '$post_title', '$post_content', DEFAULT);");
        }
    } else if (isset($_POST['system-notification-delete'])) {
        /// --------------------------------
        /// DETECT A POST DELETION REQUEST
        /// --------------------------------

        // Cleanse the received data
        $admin_username = filter_var($_POST['system-notification-delete-admin'], FILTER_SANITIZE_STRING);
        $post_id = filter_var($_POST['system-notification-delete-id'], FILTER_SANITIZE_STRING);

        // Check if logged in user is an admin
        $admin_presence = $database_helper->get("SELECT * FROM admins WHERE username = '$admin_username';");

        // If it is an admin, delete the selected post
        if (count($admin_presence) >= 0) {
            $database_helper->set("DELETE FROM posts WHERE id=$post_id;");
        }
    }

    // Return to the monitoring page
    header('Location: status.php', true, 301);
    exit();
}
