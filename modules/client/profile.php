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
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/main.css">
    <link rel="stylesheet" href="./modules/client/assets/css/responsive.css">
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

        <a class="breadcrumb-item" href="/">
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            Profile
        </a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Tài khoản của tôi</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="?module=client&action=profile&layout=hosoUser">Hồ sơ</a>
                            </li>
                            <li class="list-group-item">
                                <a href="?module=client&action=profile&layout=resetpassword">Đổi mật khẩu</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['layout'])) {
                $layout = $_GET['layout'];
            } else {
                $layout = 'hosoUser';
            }
            include_once './modules/client/' . $layout . '.php';
            ?>
        </div>
    </div>

    <?php
    include_once './modules/layout/footer.php';
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('#form-reset').submit(function(e) {
                var password = $('#password').val();
                var rpassword = $('#rpassword').val();
                if (password != rpassword) {
                    alert('Mật khẩu không trùng khớp');
                    e.preventDefault();
                } else {
                    $.ajax({
                        url: 'http://localhost/ShopHoaQua/modules/auth/reset_password.php',
                        type: 'post',
                        data: {
                            'password': password,
                            'rpassword': rpassword
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                document.querySelector('.alert').classList.add('alert-success');
                                document.querySelector('.alert strong').innerHTML = data.message;
                            } else {
                                document.querySelector('.alert').classList.add('alert-danger');
                                document.querySelector('.alert strong').innerHTML = data.message;
                            }
                        }
                    });
                }
            });

            $('#form-profile').submit(function(e) {
                let username = $('#username').val();
                let email = $('#email').val();
                let phone = $('#phone').val();
                $.ajax({
                    url: 'http://localhost/ShopHoaQua/modules/auth/update_user_info.php',
                    type: 'post',
                    data: {
                        'username': username,
                        'email': email,
                        'phone': phone
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            document.querySelector('.alert').classList.add('alert-success');
                            document.querySelector('.alert strong').innerHTML = data.message;
                        } else {
                            document.querySelector('.alert').classList.add('alert-danger');
                            document.querySelector('.alert strong').innerHTML = data.message;
                        }
                    }
                })
            })
        });
    </script>
</body>

</html>