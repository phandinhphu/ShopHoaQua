<?php
session_start();

if (empty($_SESSION['username'])) {
    header('Location: ?module=client&action=login');
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addToCart']) && ($_POST['addToCart'] == '')) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            if (array_key_exists($id, $cart)) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'title' => $title,
                    'price' => $price,
                    'quantity' => $quantity
                ];
            }
        } else {
            $cart = [
                $id => [
                    'title' => $title,
                    'price' => $price,
                    'quantity' => $quantity
                ]
            ];
        }

        $_SESSION['cart'] = $cart;
    
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="shortcut icon" href="https://th.bing.com/th/id/R.74bff8ec53bb5bc71046aaa4a21fe9a5?rik=3d39%2f638LB5vog&pid=ImgRaw&r=0" type="image/x-icon">
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
        <span class="breadcrumb-item active">Giỏ hàng</span>
    </nav>

    <session class="container">
        <h1 class="text-center">Giỏ hàng</h1>
        <table class="table table-striped table-inverse">
            <thead class="thead-inverse">
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stt = $total = 0;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $total += $value['price'] * $value['quantity'];
                ?>
                <tr>
                    <td><?= ++$stt ?></td>
                    <td><?= $value['title'] ?></td>
                    <td><?= $value['price'] ?></td>
                    <td><?= $value['quantity'] ?></td>
                    <td><?= $value['price'] * $value['quantity'] ?></td>
                    <td>
                        <a href="?module=client&action=remove_cart&id=<?= $key ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
                <tr>
                    <td colspan="4">Tổng tiền</td>
                    <td><?= $total ?></td>
                    <td>
                        <a href="?module=client&action=remove_cart" class="btn btn-danger">Xóa All</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </session>

    <div class="info__user">
        <div class="container">
            <h3>Thông tin khách hàng</h3>
            <form action="?module=client&action=thanhtoan" method="post">
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
                    
                    <button type="submit" name="thanhtoan" class="btn btn-primary">Đặt hàng</button>
                </div>
            </form>
        </div>
    </div>
    

    <?php
        include_once './modules/layout/footer.php';
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="./modules/client/assets/js/main.js"></script>
</body>
</html>