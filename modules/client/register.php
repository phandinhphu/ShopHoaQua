<?php
session_start();
require_once './db/database.php';

$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $cpwd = $_POST['cpwd'];

    if (strlen($username) < 6) {
        $error['username'] = 'Tên đăng nhập phải lớn hơn 6 ký tự';
    }

    if (!preg_match('/^(0)[0-9]{9}$/', $phone)) {
        $error['phone'] = 'Số điện thoại không hợp lệ';
    }

    $dataEmail = [
        'email' => $email
    ];

    $emailDB = getRow('SELECT * FROM users WHERE email = :email', $dataEmail);
    if ($emailDB) {
        $error['email'] = 'Email đã tồn tại';
    }

    if (strlen($pwd) < 6) {
        $error['pwd'] = 'Mật khẩu phải lớn hơn 6 ký tự';
    }

    if ($pwd != $cpwd) {
        $error['cpwd'] = 'Mật khẩu không khớp';
    }

    if (empty($error)) {
        $data = [
            'username' => $username,
            'phone' => $phone,
            'email' => $email,
            'password' => password_hash($pwd, PASSWORD_DEFAULT),
            'activeToken' => md5($email).time(),
            'createdAt' => date('Y-m-d H:i:s')
        ];
        $result = insert('users', $data);
        echo $result;
        var_dump($result);
        if ($result == NULL) {
            header('Location: ?module=client&action=login');
        } else {
            $error['register'] = 'Đăng ký thất bại';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/login_register.css">
</head>

<body>
    <form action="?module=client&action=register" method="post">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="text-center">Đăng Ký</h2>
                    <?php if (!empty($error['register'])) { ?>
                        <p class="text-danger"><?php echo $error['register']; ?></p>
                    <?php } ?>
                    <div class="form-group">
                        <input type="text" name="username" class="input__text" id="username" required>
                        <label class="input__label" for="username">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            Full Name:
                        </label>
                        <?php if (!empty($error['username'])) { ?>
                            <p class="text-danger"><?php echo $error['username']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <input type="number" name="phone" class="input__text" id="phone" required>
                        <label class="input__label" for="phone">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            Phone:
                        </label>
                        <?php if (!empty($error['phone'])) { ?>
                            <p class="text-danger"><?php echo $error['phone']; ?></p>
                        <?php } ?>
                    </div>
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
                        <input type="password" name="pwd" class="input__text" id="pwd" required>
                        <label class="input__label" for="pwd">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            Mật Khẩu:
                        </label>
                        <?php if (!empty($error['password'])) { ?>
                            <p class="text-danger"><?php echo $error['password']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="cpwd" class="input__text" id="cpwd" required>
                        <label class="input__label" for="cpwd">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            Nhập Lại Mật Khẩu:
                        </label>
                        <?php if (!empty($error['cpwd'])) { ?>
                            <p class="text-danger"><?php echo $error['cpwd']; ?></p>
                        <?php } ?>
                    </div>
                    <input type="submit" value="Đăng Ký" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>

    <script>
        var inputLabels = document.querySelectorAll('.input__label');
        var inputTexts = document.querySelectorAll('.input__text');
        inputTexts.forEach((inputText, index) => {
            inputText.addEventListener('focus', () => {
                inputLabels[index].classList.add('active');
            });
            inputText.addEventListener('blur', () => {
                if (inputText.value === '') {
                    inputLabels[index].classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>