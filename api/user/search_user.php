<?php
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['search'])) {
        http_response_code(422);
        echo json_encode(['message' => 'Search is required']);
        return;
    }
    $search = trim($_POST['search']);
    $data = [
        'username' => "%$search%"
    ];
    $users = getRows("SELECT * FROM user WHERE username LIKE :username", $data);
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
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}