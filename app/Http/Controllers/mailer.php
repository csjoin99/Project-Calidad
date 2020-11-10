<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class mailer extends Controller
{
    public function index($pdf, $name, $correo)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'csjoin98@gmail.com';                     // SMTP username
            $mail->Password   = 'curo_99_1';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;
            // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //Recipients
            $mail->setFrom('csjoin98@gmail.com', 'ClothingandMore');
            $mail->addAddress($correo, $name);     // Add a recipient
            
            // Attachments
            $mail->addStringAttachment($pdf->Output(), 'OrderDetails.pdf', $encoding = 'base64', $type = 'application/pdf');
            // Add attachments

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Factura';
            $mail->Body    = 'Se le esta enviando la factura de su compra</b>';

            $mail->send();
            return ;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('shop')->with('failure_message', 'No se pudo proceder con el pago' . $th->getMessage());
        }
    }
}
