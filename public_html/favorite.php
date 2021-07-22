<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle-city-favorite'])) {
    $selected_city_rank = $_POST['toggle-city-favorite'];
    echo "Working with SELECTED_CITY_RANK: " . $selected_city_rank;
}
