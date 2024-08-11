<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (Jika Anda menggunakan Composer)
require '../vendor/autoload.php';

// Inisialisasi PHPMailer
$mail = new PHPMailer(true);

$response = array('type' => 'danger', 'message' => 'Message could not be sent.');

try {
    // Pengaturan server SMTP
    $mail->isSMTP();                           // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';     // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                // Enable SMTP authentication
    $mail->Username   = ''; // SMTP username (email)
    $mail->Password   = '';       // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
    $mail->Port       = 465;

    // Pengaturan penerima email
    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress('iemaduddin17@gmail.com'); // Ganti dengan email penerima
    $mail->addReplyTo($_POST['email'], $_POST['name']);

    // Pengaturan konten email
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body    = nl2br($_POST['message']);
    $mail->AltBody = strip_tags($_POST['message']);

    // Kirim email
    $mail->send();
    $response = array('type' => 'success', 'message' => 'Message has been sent');
} catch (Exception $e) {
    $response['message'] = "Mailer Error: {$mail->ErrorInfo}";
}

// Mengirimkan response dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
