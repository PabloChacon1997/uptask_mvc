<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

  protected $email;
  protected $nombre;
  protected $token;


  public function __construct($email, $nombre ,$token)
  {
    $this->email = $email;
    $this->nombre = $nombre;
    $this->token = $token;
  }
  public function enviarConfirmacio() {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'f4aecc9ccd9107';
    $mail->Password = '6b529534b5a3fd';

    $mail->setFrom('cuestas@uptask.com');
    $mail->addAddress('cuentas@uptask.com', 'uptask.com');
    $mail->Subject = 'Confirma tu cuenta';

    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';

    $constenido = '<html>';
    $constenido .= '<p><strong>Hola'.$this->nombre.'</strong> Has creado tu cuenta en UpTask solo debes confirmarla en el siguiente enlace</p>';
    $constenido .= '<p>Presiona aqui: <a href="http://localhost:3000/confirmar?token='.$this->token.'">Confirmar cuenta</a></p>';
    $constenido .= '<p>Si tu no solicitaste esta cuenta, ignora este mensaje</p>';
    $constenido .= '</html>';

    $mail->Body = $constenido;

    // Enviar email
    $mail->send();
  }
  public function enviarIntrucciones() {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'f4aecc9ccd9107';
    $mail->Password = '6b529534b5a3fd';

    $mail->setFrom('cuestas@uptask.com');
    $mail->addAddress('cuentas@uptask.com', 'uptask.com');
    $mail->Subject = 'Restablece tu password';

    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';

    $constenido = '<html>';
    $constenido .= '<p><strong>Hola'.$this->nombre.'</strong>. Parece que has olvidado tu password</p>';
    $constenido .= '<p>Presiona aqui: <a href="http://localhost:3000/restablecer?token='.$this->token.'">Restablecer password</a></p>';
    $constenido .= '<p>Si tu no solicitaste esta acción, ignora este mensaje</p>';
    $constenido .= '</html>';

    $mail->Body = $constenido;

    // Enviar email
    $mail->send();
  }
}