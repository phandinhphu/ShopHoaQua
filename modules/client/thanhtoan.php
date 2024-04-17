<?php
session_start();
require_once './include/function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['thanhtoan']) && ($_POST['thanhtoan'] == '')) {
        $total = $_POST['total'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $phuongThucTT = $_POST['payment'];
        $maDH = "WCMS".rand(0, 9999999);

        $idDH = taoDonHang($maDH, $total, $phuongThucTT, $name, $address, $email, $phone);

        if ($idDH > 0) {
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                    $idSP = $key;
                    $soLuong = $value['quantity'];
                    $gia = $value['price'];
                    $data = [
                        'idOrder' => $idDH,
                        'idProduct' => $idSP,
                        'quantity' => $soLuong,
                        'dongia' => $gia,
                    ];
                    insert('carts', $data);
                }
            }
            unset($_SESSION['cart']);
        }
    }
    include_once './modules/client/donhang.php';
} else {
    header('Location: ?module=client&action=trangchu');
    die();
}