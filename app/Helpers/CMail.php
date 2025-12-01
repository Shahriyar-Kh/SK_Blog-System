<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CMail
{
public static function sendMail($config)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();

        $mail->Host       = config('services.mail.host');
        $mail->SMTPAuth   = true;
        $mail->Username   = config('services.mail.username');
        $mail->Password   = config('services.mail.password');
        $mail->SMTPSecure = config('services.mail.encryption');
        $mail->Port       = config('services.mail.port');

        $mail->setFrom(
            $config['from_address'] ?? config('services.mail.from.address'),
            $config['from_name'] ?? config('services.mail.from.name')
        );

        $mail->addAddress($config['recipient_address'], $config['recipient_name'] ?? null);

        $mail->isHTML(true);
        $mail->Subject = $config['subject'];
        $mail->Body    = $config['body'];

        return $mail->send();
    } catch (Exception $e) {
        // For debugging, temporarily uncomment the next line:
        // dd('Mail Error: ' . $e->getMessage());
        return false;
    }
}

}