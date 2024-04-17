<?php
session_start();
require_once './db/database.php';

if (!empty($_SESSION['username'])) {
    header('Location: ?module=client&action=trangchu');
    exit();
}

$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    $dataEmail = [
        'email' => $email
    ];

    $emailDB = getRow('SELECT * FROM users WHERE email = :email', $dataEmail);

    if (count($emailDB) == 0) {
        $error['email'] = 'Email không tồn tại';
    }

    if (strlen($pwd) < 6) {
        $error['pwd'] = 'Mật khẩu phải lớn hơn 6 ký tự';
    }

    if (!password_verify($pwd, $emailDB['password'])) {
        $error['password'] = 'Mật khẩu không đúng';
    }

    if (empty($error)) {
        $_SESSION['username'] = $emailDB['username'];
        header('Location: ?module=client&action=trangchu');
    } else {
        $error['login'] = 'Đăng nhập thất bại';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="shortcut icon" href="https://th.bing.com/th/id/R.74bff8ec53bb5bc71046aaa4a21fe9a5?rik=3d39%2f638LB5vog&pid=ImgRaw&r=0" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/login_register.css">
</head>

<body>
    <form action="?module=client&action=login" method="post">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2>Đăng Nhập</h2>
                    <?php if (!empty($error['login'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error['login']; ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($_SESSION['flash_success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?= getFlashData('success') ?>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <input type="email" name="email" class="input__text" id="email" required>
                        <label class="input__label" for="email">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            Email:
                        </label>
                        <?php if (!empty($error['email'])) { ?>
                            <p class="text-danger"><?php echo $error['email']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="input__text" id="pwd" required>
                        <label class="input__label" for="pwd">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            Mật Khẩu:
                        </label>
                        <?php if (!empty($error['password'])) { ?>
                            <p class="text-danger"><?php echo $error['password']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group text-right">
                        <a class="form__link" href="?module=client&action=register">Đăng ký</a>
                        <a class="form__link" href="?module=client&action=forgot.php">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                </div>
            </div>
        </div>
    </form>

    <script src="./modules/client/assets/js/login_register.js"></script>
</body>

</html>