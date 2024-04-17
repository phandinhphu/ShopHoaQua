<?php
session_start();
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['oldPassword'];
    $password = $_POST['password'];

    $rs = getRow('SELECT * FROM users WHERE username = :username', ['username' => $_SESSION['username']]);

    if (!password_verify($old_password, $rs['password'])) {
        $status = '0';
        $msg = 'Mật khẩu cũ không đúng';
        $dataMsg = [
            'status' => $status,
            'msg' => $msg,
        ];
        header('Content-Type: application/json');
        echo json_encode($dataMsg);
        exit();
    }

    $data = [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'updatedAt' => date('Y-m-d H:i:s'),
    ];

    $where = [
        'username' => $_SESSION['username'],
    ];

    $rs = update('users', $data, $where);
    if ($rs == NULL) {
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