<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $orderDetails = getRows('SELECT maDH, product.title, carts.quantity, carts.dongia
                                FROM orders, carts, product
                                WHERE orders.id = carts.idOrder and 
                                    carts.idProduct = product.id and 
                                    orders.id = :id', ['id' => $id]);
        header('Content-type: application/json');
        echo json_encode($orderDetails);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}
