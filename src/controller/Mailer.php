<?php


namespace src\controller\Mailer;
use src\PHPMailer;

class Mailer {

    static function sendMail($email){
        $mail = new PHPMailer();

        $mail->isSMTP();                        // Utilizar SMTP
        $mail->Host       = 'NOMBRE DEL SERVIDOR SMTP';    // Servidor SMTP
        $mail->SMTPAuth   = true;               // Autenticacion SMTP
        $mail->Username   = 'USUARIO SMTP';     // Usuario SMTP
        $mail->Password   = 'PASSWORD SMTP';         // Password SMTP
        $mail->SMTPSecure = 'tls';              // encriptado tls o ssl
        $mail->Port       = 587;                // Puerto smtp

        $mail->setFrom('from@gfg.com', 'Name');           // Correo y nombre del remitente
        $mail->addAddress($email);           // Correo del destinatario

        $mail->isHTML(true);                                  
        $mail->Subject = 'Su cuenta ha sido creada';
        $mail->Body    = '<p>Puede activarla pulsando el siguiente enlace</p><a href="//ENLACE ACTIVACION CUENTA">Activar cuenta</a>';

        //$mail->send();

    }


}
