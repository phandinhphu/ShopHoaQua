<?php
require_once(__DIR__ . '/../../db/database.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $where = [
        'id' => $id
    ];
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'delete':
                delete('product', $where);
                break;
        }
    }
}
?>