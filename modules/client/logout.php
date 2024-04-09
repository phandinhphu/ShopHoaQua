<?php
session_start();

if ($_SESSION['username']) {
    session_destroy();
    header('Location: ?module=client&action=login');
    exit();
} else {
    header('Location: ?module=client&action=login');
    exit();
}