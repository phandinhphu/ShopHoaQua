<?php
require_once '../../db/database.php';

function getThumbnail() {
    $thumbnails = getRows('SELECT id, thumbnail FROM product');
    header('Content-Type: application/json');
    echo json_encode($thumbnails);
}

getThumbnail();