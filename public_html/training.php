<?php

session_start();

require_once('./helpers/ThemeHelper.php');
$theme_color = 'blue';
if (isset($_SESSION['theme'])) {
    $theme_color = $_SESSION['theme'];
}

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

?>

<html>

<head>
    <title>User Training</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="stylesheet" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="styles/staticStyle.css">
    <style>
	.video-container { position: relative; padding-bottom: 56.25%; padding-top: 30px; height: 0; overflow: hidden; }

	.video-container iframe, .video-container object, .video-container embed { position: absolute; top: 0; left: 5%; width: 90%; height: 90%; }

    </style>


    <script src="login.js"></script>
</head>

<body class="sidebar-navigation">
    <aside>
        <?php require('navigation.php'); ?>
    </aside>

    <main>
        <section id="user-controls-section">
            <div id="user-controls">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "Welcome, <a class='profile-link' href='profile.php'>" . $_SESSION['username'] . "</a>";
                } else {
                    echo "<form action='login.php'><input class='universal-login-button' type='submit' style='cursor: pointer;' value='Log In'></form>";
                }
                ?>
            </div>
        </section>

	<section>
		<h2>User Training</h2>
		<br><br>

		<div class="video-container">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/0FBFpGkqyig" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>


		<br><br><br><br>

	</section>

        
    </main>

    <footer>
        <?php echo ThemeHelper::get_theme_switcher($theme_color); ?>
    </footer>

</body>

</html>
