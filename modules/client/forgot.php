<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $user = getRow("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    if (!$user) {
        $error = 'Email không tồn tại';
    } else {
        $subject = 'Quên mật khẩu';
        $token = md5($email . time());
        update('users', ['forgotToken' => $token], ['email' => $email]);
        $body = 'Click vào link sau để đổi mật khẩu: <a href="https://5cf3-117-2-51-36.ngrok-free.app/ShopHoaQua/?module=auth&action=forgot_password&token=' . $token . '">Đổi mật khẩu</a>';
        sendMail($email, $subject, $body);
        setFlashData('success', 'Vui lòng kiểm tra email để đổi mật khẩu');
        setFlashData('email', $email);
        header('location: ?module=client&action=login');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
</head>

<body>
    <form action="?module=client&action=forgot" method="post">
        <div class="form-group">
            <label class="input__label" for="email">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                Email:
            </label>
            <?= isset($error) ? $error : '' ?>
            <input type="email" name="email" class="input__text" id="email" required>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</body>

</html>