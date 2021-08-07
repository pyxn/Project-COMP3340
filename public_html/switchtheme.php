<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['theme'] = $_POST['next-theme'];
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
