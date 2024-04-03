<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $message)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'phuphandinh2004@gmail.com';                     //SMTP username
        $mail->Password   = 'tebd hrzo dujx nvcr';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('phuphandinh2004@gmail.com', 'Phan Dinh Phu');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Gửi thành công';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function taoDonHang($maDH, $total, $pttt, $name, $address, $email, $phone) {
    $dataEmail = [
        'email' => $email
    ];
    $idUser = getRow('SELECT id FROM users WHERE email = :email', $dataEmail)['id'];
    $data = [
        'maDH' => $maDH,
        'tongDH' => $total,
        'phuongThucTT' => $pttt,
        'idUser' => $idUser,
        'name' => $name,
        'address' => $address,
        'email' => $email,
        'phone' => $phone,
        'status' => 0
    ];
    $idDH = insertAndGetId('orders', $data);
    return $idDH;
}