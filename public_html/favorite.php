<?php

// This is a script to (toggle) create and delete user favorite records of available cities

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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle-city-favorite']) && isset($_POST['username'])) {

    // Get posted rank and username
    $selected_city_rank     = $_POST['toggle-city-favorite'];
    $selected_username      = $_POST['username'];

    // Connect to database
    $database_helper = new DatabaseHelper($db_hostname, $db_name, $db_username, $db_password);

    // Find city with the posted rank
    $selected_city_record_array = $database_helper->get("SELECT * FROM cities WHERE rank = $selected_city_rank");

    // Get city name and province code
    $selected_city_name = $selected_city_record_array[0]['city_town'] . ", " . $selected_city_record_array[0]['province'];

    // Create the favorites table if it doesn't exist
    if ($database_helper->is_this_table_created("favorites") == false) {
        $database_helper->set("CREATE TABLE `favorites` (`username` VARCHAR(255) NOT NULL, `favorite_city_rank` INT, `favorite_city_name` VARCHAR(255))");
    }

    // Check if user has favorite record of current city
    $user_favorite_record = $database_helper->get("SELECT * FROM favorites WHERE username = '$selected_username' AND favorite_city_rank = $selected_city_rank");

    // Toggling a favorite
    // Create the record if it doesn't exist
    // Delete the record if it exists
    if (count($user_favorite_record) == 0) {
        $database_helper->set("INSERT INTO favorites(username, favorite_city_rank, favorite_city_name) VALUES ('$selected_username', $selected_city_rank, '$selected_city_name');");
        $new_user_favorite_record = $database_helper->get("SELECT * FROM favorites WHERE username = '$selected_username' AND favorite_city_rank = $selected_city_rank");
    } else {
        if (isset($_POST['undo-favorite'])) {
            $database_helper->set("DELETE FROM favorites WHERE username = '$selected_username' AND favorite_city_rank = $selected_city_rank");
        }
    }

    // Return to the current city page the user is in
    header("Location: city.php?rk=" . $selected_city_rank);
    exit(0);
}
