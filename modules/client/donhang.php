<?php

if (empty($_SESSION['username'])) {
    header('Location: ?module=client&action=login');
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/main.css">
    <style>
        .table {
            margin-top: 20px;
        }

        .table thead th {
            border: 1px solid #000;
        }

        .table td {
            border: 1px solid #000;
            line-height: 3.4;
        }
    </style>
</head>

<body>
    <?php
    include_once './modules/layout/header.php';
    ?>

    <nav class="breadcrumb" style="margin-top: 56px;">
        <a class="breadcrumb-item" href="?module=client&action=trangchu">
            <i class="fa fa-home" aria-hidden="true"></i>
            Trang chủ
        </a>
        <span class="breadcrumb-item active">Đơn hàng</span>
    </nav>

    <session class="container">
        <h3>ID đơn hàng <?= $idDH ?></h3>
        <h1 class="text-center">Giỏ hàng</h1>
        <table class="table table-striped table-inverse">
            <thead class="thead-inverse">
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = $total = 0;
                $carts = getRows('SELECT carts.*, product.title as title FROM carts join product 
                                on carts.idProduct = product.id
                                WHERE idOrder = :idOrder', ['idOrder' => $idDH]);
                if (count($carts) > 0) {
                    foreach ($carts as $key => $value) {
                        $total += $value['dongia'] * $value['quantity'];
                ?>
                        <tr>
                            <td><?= ++$stt ?></td>
                            <td><?= $value['title'] ?></td>
                            <td><?= $value['dongia'] ?></td>
                            <td><?= $value['quantity'] ?></td>
                            <td><?= $value['dongia'] * $value['quantity'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="4">Tổng tiền</td>
                    <td><?= $total ?></td>
                </tr>
            </tbody>
        </table>
    </session>

    <div class="info__user">
        <div class="container">
            <h3>Thông tin khách hàng</h3>
            <input type="hidden" name="total" value="<?= $total ?>">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" class="form-control" id="name" name="email" required>

                <label for="phone">Số điện thoại</label>
                <input type="number" class="form-control" id="phone" name="phone" required>

                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>

                <option value="">Phương thức thanh toán</option>
                <select name="payment" id="payment" class="form-control">
                    <option value="1">Thanh toán khi nhận hàng</option>
                    <option value="2">Thanh toán qua thẻ</option>
                </select>
            </div>
        </div>
    </div>


    <?php
    include_once './modules/layout/footer.php';
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>