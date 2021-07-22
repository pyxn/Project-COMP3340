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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle-city-favorite']) && isset($_POST['username'])) {

    $selected_city_rank     = $_POST['toggle-city-favorite'];
    $selected_username      = $_POST['username'];

    // Use the ULTIMATE PAO shortcut for making database changes
    $database_helper = new DatabaseHelper($db_hostname, $db_name, $db_username, $db_password);
    $selected_city_record_array = $database_helper->get("SELECT * FROM cities WHERE rank = $selected_city_rank");
    $selected_city_name = $selected_city_record_array[0]['city_town'] . ", " . $selected_city_record_array[0]['province'];

    echo "<pre>";
    echo "Working with USERNAME           : " . $selected_username  . "<br>";
    echo "Working with SELECTED_CITY_RANK : " . $selected_city_rank . "<br>";
    echo "Working with SELECTED_CITY_NAME : " . $selected_city_name . "<br>";
    echo "Working with ARRAY  : "                       . "<br>";
    echo print_r($selected_city_record_array);
    echo "<br>";

    if ($database_helper->is_this_table_created("favorites") == false) {
        echo "The 'favorites' table is not present.<br>";
        $database_helper->set("CREATE TABLE `favorites` (`username` VARCHAR(255) NOT NULL, `favorite_city_rank` INT, `favorite_city_name` VARCHAR(255))");
        echo "The 'favorites' table has been created.<br>";
    }

    // Check if user already has a record of making this city a favorite
    $user_favorite_record = $database_helper->get("SELECT * FROM favorites WHERE username = '$selected_username' AND favorite_city_rank = $selected_city_rank");

    // If the result returns zero rows, create a new favorite record for the user
    if (count($user_favorite_record) == 0) {
        $database_helper->set("INSERT INTO favorites(username, favorite_city_rank, favorite_city_name) VALUES ('$selected_username', 1, '$selected_city_name');");
        echo "A new favorite record has been created for ($selected_username) -> (RANK: $selected_city_rank, NAME: $selected_city_name)<br>";
        $new_user_favorite_record = $database_helper->get("SELECT * FROM favorites WHERE username = '$selected_username' AND favorite_city_rank = $selected_city_rank");
        print_r($new_user_favorite_record);
    } else {
        echo "There is already a favorite record for this user: <br>";
        print_r($user_favorite_record);
    }

    echo "</pre>";
}
