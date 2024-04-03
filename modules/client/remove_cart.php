<?php
session_start();
if (empty($_SESSION['username'])) {
    header('Location: ?module=client&action=login');
    die();
}

if (!isset($_GET['id'])) {
    unset($_SESSION['cart']);
    header('Location: ?module=client&action=giohang');
    die();
} else {
    unset($_SESSION['cart'][$_GET['id']]);
    header('Location: ?module=client&action=giohang');
    die();
}