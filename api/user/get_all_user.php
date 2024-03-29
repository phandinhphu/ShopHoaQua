<?php
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM user";
    $users = getRows($sql);
    if ($users) {
        header('Content-Type: application/json');
        $data = [
            'status' => '1',
            'data' => $users
        ];
    } else {
        $data = [
            'status' => '0',
            'message' => 'Not found data user'
        ];
    }
    echo json_encode($data);
}