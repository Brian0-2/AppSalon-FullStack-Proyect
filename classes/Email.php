<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

//CLASE
class Email
{

    public $email;
    public $nombre;
    public $token;
    //constructor
    public function __construct($email, $nombre, $token)
    {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    //ENVIAR CORREO
    public function enviarConfirmacion()
    {

        //crear objeto email
        //Inserto mis credenciales del servidor de correos
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'bd9e097fbb151d';
        $mail->Password = '8bfb5f9901797f';

        //Enviar a mi servidor
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu Cuenta';

        //Mi html
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->email .  "</strong> Has Creado tu cuenta en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

        //Colocarlo en mi body
        $mail->Body = $contenido;

        //Enviar email
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        //crear objeto email
        //Inserto mis credenciales del servidor de correos
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'bd9e097fbb151d';
        $mail->Password = '8bfb5f9901797f';

        //Enviar a mi servidor
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu contraseña';

        //Mi html
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has solicitado restablecer tu contraseña,
                                                                       sigue el siguiente enlace para reestablecer tu contraseña.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

        //Colocarlo en mi body
        $mail->Body = $contenido;

        //Enviar email
        $mail->send();
    }
}//CIERRE DE CLASE      