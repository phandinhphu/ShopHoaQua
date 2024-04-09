<?php
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM users";
    $users = getRows($sql);
    if ($users) {
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
    header('Content-Type: application/json');
    echo json_encode($data);
}