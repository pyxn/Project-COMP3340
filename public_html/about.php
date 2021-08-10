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

?>

<html>

<head>
    <title>About Page</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="stylesheet" href="styles/main.css" />
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
		<h2> New City, Better Life</h2>
		<p>A new survey found that almost one quarter (23%) of Canadians moved or plan to move since April 2020 cited COVID-19 as a reason for relocating. Our website is aiming to help people to find their dream city by providing information of the most livable places in Canada. The main functionalities are implemented through generation of dynamic pages producing list of cities based on client priorities and the comparison among these cities.</p>
	</section>

        
    </main>

    <footer>
        <?php echo ThemeHelper::get_theme_switcher($theme_color); ?>
    </footer>
</body>

</html>
