<?php

session_start();

require_once('./helpers/DatabaseHelper.php');

if (isset($_SESSION['admin_username'])) {
    $admin_username = $_SESSION['admin_username'];
} else {
    $admin_username = "";
}

// Main Server
$sql_configuration_array    = parse_ini_file("../../../../sql-config.ini", true);

// Test Server
if ($_SERVER['SERVER_NAME'] == 'newcitybetterlife.com' || $_SERVER['HTTP_HOST'] == 'newcitybetterlife.com') {
    $sql_configuration_array    = parse_ini_file("../sql-config.ini", true);
}

$db_name                    = $sql_configuration_array['database']['database'];
$db_hostname                = $sql_configuration_array['database']['hostname'];
$db_username                = $sql_configuration_array['database']['username'];
$db_password                = $sql_configuration_array['database']['password'];
$database_helper = new DatabaseHelper($db_hostname, $db_name, $db_username, $db_password);
$posts = array();

if ($database_helper->is_this_table_created("posts") == true) {
    $posts = $database_helper->get("SELECT * FROM posts ORDER BY timestamp DESC;");
}

echo "<!-- <pre>";
print_r(NULL);
echo "</pre> -->";

$services = array(
    array("port" => "80", "name" => "Apache (HTTP)", "host" => "localhost"),
    array("port" => "443", "name" => "Apache (HTTP/SSL)", "host" => "localhost"),
    array("port" => "22", "name" => "Secure Shell (SSH)", "host" => "localhost"),
    array("port" => "21", "name" => "File Transfer Protocol (FTP)", "host" => "localhost"),
    array("port" => "3306", "name" => "MySQL Database", "host" => "localhost"),
    array("port" => "80", "name" => "Internet Connection", "host" => "google.com")
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>New City Better Life | Status</title>
    <meta content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-a11y="true"></script>
</head>
<html>

<body>

    <header class="p-3 bg-dark text-white">
        <div class="container">
            <section class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none" style='color: white;'>
                    <h6 class='align-items-center my-1'>New City Better Life | System Status</h6>
                </a>
                <div class="text-end">
                    <!-- <button type="button" class="btn btn-outline-light me-2">Admin Login</button>
                    <button type="button" class="btn btn-warning">Admin Register</button> -->
                </div>
            </section>
        </div>
    </header>

    <main role="main" class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8 blog-main">

                <article class="card mt-4">
                    <h5 class="card-header">System Notifications</h5>
                    <div class="card-body">

                        <div class="card border-0 mb-3">
                            <div class="card-body">
                                <h4 class="card-title">Post System Notification</h4>
                                <h6 class="card-subtitle mb-2 text-muted mb-4">Administrator (<?php echo $admin_username; ?>)</h6>
                                <form method="POST" action='post.php'>
                                    <input type='hidden' name='system-notification-create' value="1">
                                    <input type='hidden' name='system-notification-post-author' value="<?php echo $admin_username; ?>">
                                    <div class=" form-group mt-3">
                                        <label for="system-notification-post-title" class="mb-2">Notification Title</label>
                                        <input type="text" class="form-control" name='system-notification-post-title'>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="system-notification-post-content" class="mb-2">Notification Content</label>
                                        <textarea class="form-control" name='system-notification-post-content' id='system-notification-post-content' rows='5'></textarea>
                                    </div>
                                    <button type=" submit" class="btn btn-primary my-4">Post Notification</button>
                                </form>
                            </div>
                            <div class="dropdown-divider"></div>
                        </div>

                        <!-- --------------------------------------------------------
                            AUTO-GENERATE POSTS FROM DATABASE
                        ------------------------------------------------------------>

                        <?php
                        foreach ($posts as &$post) {
                            $system_post_id = $post['id'];
                            $system_post_author = $post['username'];
                            $system_post_title = $post['post_title'];
                            $system_post_content = $post['post_content'];
                            $system_post_timestamp = $post['timestamp'];

                            echo "
                            <div class='card border-0 mb-3'>
                            <div class='card-body'>
                                <h5 class='card-title'>$system_post_title</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>Posted by $system_post_author</h6>
                                <p class='card-text'>$system_post_content</p>
                                <p class='card-text'>
                                    <small class='text-muted'>
                                        <form method='POST' action='post.php' id='system-notification-$system_post_id'>
                                            $system_post_timestamp
                                            <input type='hidden' name='system-notification-delete'>
                                            <input type='hidden' name='system-notification-delete-admin' value='$admin_username'>
                                            <input type='hidden' name='system-notification-delete-id' value='$system_post_id'>
                                            <a href='#' onclick='document.getElementById('system-notification-$system_post_id').submit()>
                                                <span style='color: gray;' class='fas fa-trash mx-3'></span>
                                            </a>
                                        </form>
                                    </small>
                                </p>
                            </div>
                            <div class='dropdown-divider'></div>
                            </div>
                            ";
                        }
                        ?>

                        <!-- <nav class="blog-pagination mt-4">
                            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
                            <a class="btn btn-outline-primary" href="#">Older</a>
                        </nav> -->

                    </div>
                </article>
            </div>

            <!-- --------------------------------------------------------
                SIDEBAR
            ------------------------------------------------------------>
            <aside class="col-md-4 blog-sidebar">
                <section class="card text-dark mb-3 mt-4">
                    <h5 class="card-header text-center">
                        Server Status
                    </h5>
                    <div class="card-body">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Port</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($services as &$service) {

                                    $service_name = $service['name'];
                                    $service_port = $service['port'];
                                    $service_ip = $service['host'];
                                    $service_online = false;

                                    if ($service['name'] == 'MySQL Database') {
                                        $sql_connection = mysqli_connect($db_hostname, $db_username, $db_password);
                                        if (!$sql_connection) {
                                            $service_online = false;
                                        } else {
                                            $service_online = true;
                                        }
                                    } else {
                                        $socket_connected = @fsockopen($service['host'], $service['port'], $error_code, $error_message, 1);
                                        if ($socket_connected != false) {
                                            $service_online = true;
                                        }
                                    }
                                    fclose($socket_connected);

                                    if ($service_online) {
                                        echo "<tr><td>$service_name</td><td>$service_port</td><td style='color: green;'>Online <span class='fa fa-check-circle'></span></td></tr>";
                                    } else {
                                        echo "<tr><td>$service_name</td><td>$service_port</td><td style='color: red;'>Offline <span class='fa fa-times-circle'></span></td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="card text-dark mb-3 mt-4">
                    <h5 class="card-header text-center">
                        Server information
                    </h5>
                    <div class="card-body">
                        <table class='table'>
                            <tbody>
                                <tr>
                                    <td>Server Name</td>
                                    <td><?php echo $_SERVER['SERVER_NAME']; ?></td>
                                </tr>
                                <tr>
                                    <td>Server Software</td>
                                    <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                                </tr>
                                <tr>
                                    <td>Server Protocol</td>
                                    <td><?php echo $_SERVER['SERVER_PROTOCOL']; ?></td>
                                </tr>
                                <tr>
                                    <td>Server IP Address</td>
                                    <td><?php echo $_SERVER['SERVER_ADDR']; ?></td>
                                </tr>
                                <tr>
                                    <td>Port Accessed</td>
                                    <td><?php echo $_SERVER['SERVER_PORT']; ?></td>
                                </tr>
                                <tr>
                                    <td>Gateway Interface</td>
                                    <td><?php echo $_SERVER['GATEWAY_INTERFACE']; ?></td>
                                </tr>
                                <tr>
                                    <td>HTTP Language</td>
                                    <td><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                </section>
            </aside>

        </div>

    </main>



    </div>

</body>

</html>