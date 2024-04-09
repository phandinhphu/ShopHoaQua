<?php
session_start();
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $data = [
        'email' => $email,
        'phone' => $phone
    ];
    $where = [
        'username' => $username
    ];
    $rs = update('users', $data, $where);
    if ($rs) {
        $status = '1';
        $message = 'Cập nhật thông tin thành công';
    } else {
        $status = '0';
        $message = 'Cập nhật thông tin thất bại';
    }
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
}