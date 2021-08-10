<?php
session_start();

?>

<nav>
    <span>
        Menu
    </span>
    <ul>
        <?php
        if (!isset($_SESSION['username'])) {
            echo "<li><a href='login.php'>Log In</a></li>";
        } 
        ?>
        <li><a href="index.php">Home Page</a></li>
        <li><a href="dreamcity.php">Find Dream City</a></li>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<li><a href='profile.php'>My Favorites</a></li>";
        } 
        ?>
        <li><a href="status.php">Server Status</a></li>
        <li><a href="https://project-comp3340.gitbook.io/project/">Documentation</a></li>
        <li><a href="https://www.youtube.com/watch?v=0FBFpGkqyig">User Training</a></li>
        <li><a href="about.php">About</a></li>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<li><a href='logout.php'>Log Out</a></li>";
        }
        ?>
    </ul>
</nav>
