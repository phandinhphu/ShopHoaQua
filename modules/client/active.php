<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['token'])) {
        $activeTokenRQ = $_GET['token'];
        $activeTokenDB = getRow('SELECT * FROM users WHERE activeToken = :activeToken', ['activeToken' => $activeTokenRQ]);
        
        if ($activeTokenDB) {
            $data = [
                'activeToken' => '',
                'status' => 1
            ];
            try {
                $result = update('users', $data, ['id' => $activeTokenDB['id']]);
                header('Location: ?module=client&action=login');
                exit();
            } catch (Exception $e) {
                echo 'Đã xảy ra lỗi';
            }
        } else {
            echo 'Token không hợp lệ hoặc đã hết hạn';
        }
    }
}