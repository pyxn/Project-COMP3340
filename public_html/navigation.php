<?php
session_start();

?>

<nav>
    <span>
        Menu
    </span>
    <ul>
        <li><a href="index.php">Home Page</a></li>
        <?php
        if (!isset($_SESSION['username'])) {
            echo "<li><a href='logout.php'>Log Out</a></li>";
            echo "<li><a href='profile.php'>My Favorites</a></li>";
        } else {
            echo "<li><a href='login.php'>Log In</a></li>";
        }
        ?>
        <li><a href="dreamcity.php">Find dream city</a></li>
        <li><a href="#">Top 10 livable cities</a></li>
        <li><a href="#">About</a></li>
    </ul>
</nav>