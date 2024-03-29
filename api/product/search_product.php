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
        'title' => "%$search%"
    ];
    $products = getRows("SELECT * FROM product WHERE title LIKE :title", $data);
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}