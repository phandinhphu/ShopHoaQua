<?php
session_start();

if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử mua hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/main.css">
    <link rel="stylesheet" href="./modules/client/assets/css/responsive.css">
    <style>
        span {
            color: blue;
            cursor: pointer;
        }

        .modal {
            top: 50px;
        }

        .table {
            margin-top: 20px;
        }

        .table thead th,
        .table tbody th {
            border: 1px solid #000;
        }

        .table td {
            border: 1px solid #000;
            line-height: 3.4;
        }

        .table-wrapper {
            max-height: 300px;
            overflow-y: auto;
        }

        @media (min-width: 740px) {
            .modal-dialog {
                max-width: 800px;
                margin: 1.75rem auto;
            }
        }

        @media (max-width: 739px) {
            .modal-dialog {
                max-width: 600px;
                margin: 1.75rem auto;
            }
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

        <a class="breadcrumb-item" href="?module=client&action=search_product">
            <i class="fa fa-history" aria-hidden="true"></i>
            Lịch sử mua hàng
        </a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-heading">Lịch sử mua hàng</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Mã dơn hàng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Tên người nhận</th>
                            <th scope="col">Email</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Xem chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $username = $_SESSION['username'];
                        $id = getRows('SELECT * FROM users WHERE username = :username', ['username' => $username])[0]['id'];
                        $orderDetails = getRows('SELECT orders.*, product.title, carts.quantity, carts.dongia
                                            FROM orders, carts, product
                                            WHERE orders.id = carts.idOrder and 
                                                carts.idProduct = product.id and 
                                                idUser = :id', ['id' => $id]);
                        $orders = getRows('SELECT * FROM orders WHERE idUser = :id', ['id' => $id]);
                        foreach ($orders as $order) {
                        ?>
                            <tr>
                                <th scope="row"><?= $order['maDH'] ?></th>
                                <td><?= number_format($order['tongDH']) ?> VNĐ</td>
                                <td><?= $order['name'] ?></td>
                                <td><?= $order['email'] ?></td>
                                <td><?= $order['address'] ?></td>
                                <td><?= $order['phone'] ?></td>
                                <td><span class="jsDetail" data-id="<?= $order['id'] ?>">Chi tiết</span></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    include_once './modules/layout/footer.php';
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        document.querySelectorAll('.jsDetail').forEach(item => {
            item.addEventListener('click', function() {
                $('#modelId').modal('show');
            });
        });
        
        document.querySelectorAll('.jsDetail').forEach(item => {
            item.addEventListener('click', function() {
                const id = item.getAttribute('data-id');
                $.ajax({
                    url: 'api/order/get-order-detail.php',
                    type: 'GET',
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        let html = ``;
                        response.forEach(item => {
                            let total = item.quantity * item.dongia;
                            html += `
                                <tr>
                                    <th scope="row">${item.title}</th>
                                    <td>${item.quantity}</td>
                                    <td>${item.dongia}VNĐ</td>
                                    <td>${total}VNĐ</td>
                                </tr>
                            `;
                        })
                        $('.modal-title').html('Mã đơn hàng ' + response[0]['maDH']);
                        $('.modal-body .table tbody').html(html);
                    }
                });
            });
        });
    </script>
</body>

</html>