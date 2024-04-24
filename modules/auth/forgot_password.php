<?php
session_start();
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    setFlashData('token', $token);
    $user = getRow("SELECT * FROM users WHERE forgotToken = :forgotToken", ['forgotToken' => $token]);
    if (!$user) {
        echo 'Token không hợp lệ';
        die();
    }
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = getFlashData('token');
    $email = getRow("SELECT * FROM users WHERE forgotToken = :forgotToken", ['forgotToken' => $token])['email'];
    if ($password != $confirm_password) {
        echo 'Mật khẩu không khớp';
        die();
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $data = [
        'password' => $password,
        'forgotToken' => NULL,
        'updatedAt' => date('Y-m-d H:i:s'),
    ];
    $where = [
        'email' => $email,
    ];
    $rs = update('users', $data, $where);
    if ($rs == NULL) {
        echo 'Đổi mật khẩu thành công';
        die();
    }
    echo 'Đổi mật khẩu thất bại';
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dổi mật khẩu</title>
</head>
<body>
    <!-- Form đổi mật khẩu -->
    <form action="?module=auth&action=forgot_password" method="post">
        <div class="form-group">
            <label class="input__label" for="password">
                <i class="fa fa-lock" aria-hidden="true"></i>
                Mật khẩu mới:
            </label>
            <input type="password" name="password" class="input__text" id="password" required>
        </div>
        <div class="form-group">
            <label class="input__label" for="confirm_password">
                <i class="fa fa-lock" aria-hidden="true"></i>
                Xác nhận mật khẩu:
            </label>
            <input type="password" name="confirm_password" class="input__text" id="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>