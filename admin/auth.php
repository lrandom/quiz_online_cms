<?php
if (session_status() !== PHP_SESSION_ACTIVE || session_id() === "") {
    session_start();
}

require_once('./../../config.php');
if (!isset($_SESSION['user'])) {
    header('Location:' . BASE_URL . 'admin/login.php');
}

if (isset($_SESSION['user']) && $_SESSION['user']['level'] == 0) {
    //if la user
    header('Location:' . BASE_URL . 'index.php');
}