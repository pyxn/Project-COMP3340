<?php

// This is a script to switch between themes
session_start();

// Execute script on post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Place the posted theme to the theme session variable
    $_SESSION['theme'] = $_POST['next-theme'];
}

// Return to the referring page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
