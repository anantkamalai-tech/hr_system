<?php
namespace App\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailTest extends BaseController
{
    public function index()
    {
        require ROOTPATH . 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        try {
            // ✅ Use local Exim
            $mail->isMail();

            $mail->setFrom('support@brahmavalley.edu.in', 'HR Department');
            $mail->addAddress('prince.anantkamalstudios@gmail.com', 'Prince');

            $mail->isHTML(true);
            $mail->Subject = '✅ PHPMailer Local Mail Test';
            $mail->Body    = '<p>This email was sent using <b>Hostinger local Exim</b>.</p>';

            $mail->send();
            echo '<h2 style="color:green;">✅ Email sent successfully via local mail!</h2>';
        } catch (Exception $e) {
            echo '<h2 style="color:red;">❌ Email failed!</h2><pre>';
            echo $mail->ErrorInfo;
            echo '</pre>';
        }
    }
}
