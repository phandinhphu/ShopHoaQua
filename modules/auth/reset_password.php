<?php
session_start();
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $data = [
        '$password' => password_hash($password, PASSWORD_DEFAULT),
    ];
    $where = [
        'username' => $_SESSION['username'],
    ];
    $rs = update('users', $data, $where);
    if ($rs) {
        $status = '1';
        $msg = 'Đổi mật khẩu thành công';
    } else {
        $status = '0';
        $msg = 'Đổi mật khẩu thất bại';
    }
    $dataMsg = [
        'status' => $status,
        'msg' => $msg,
    ];
    header('Content-Type: application/json');
    echo json_encode($dataMsg);
} else {
    header('location: ../error/404.php');
}