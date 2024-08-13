<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

// Solo procesar solicitudes POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los campos del formulario y eliminar los espacios en blanco.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"), array(" "," "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $number = trim($_POST["number"]);
    $company = trim($_POST["company"]);
    $message = trim($_POST["message"]);

    // Verificar que los datos se hayan enviado al procesador de correos.
    if (empty($name) OR empty($number) OR empty($company) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Configurar un código de respuesta 400 (solicitud incorrecta) y salir.
        http_response_code(400);
        echo "Por favor completa el formulario e inténtalo de nuevo.";
        exit;
    }

    // Configurar la dirección de correo del destinatario.
    $recipient = "contacto@ai-raab.com";

    // Configurar el asunto del correo.
    $subject = "Nuevo contacto de $name";

    // Construir el contenido HTML del correo con estilos en línea.
    $email_content = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 0;'>
        <div style='width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
            <div style='text-align: center; margin-bottom: 20px;'>
                <img src='https://ai-raab.com/assets/images/AIRaab_MainLogo.webp' alt='AIRAAB' style='max-width: 150px;'>
            </div>
            <div style='line-height: 1.6;'>
                <h2 style='color: #00274c; margin-bottom: 20px;'>Nuevo Contacto</h2>
                <p style='margin-bottom: 10px;'><strong>Nombre:</strong> $name</p>
                <p style='margin-bottom: 10px;'><strong>Correo Electrónico:</strong> $email</p>
                <p style='margin-bottom: 10px;'><strong>Número de Teléfono:</strong> $number</p>
                <p style='margin-bottom: 10px;'><strong>Empresa:</strong> $company</p>
                <p style='margin-bottom: 10px;'><strong>Mensaje:</strong></p>
                <p style='margin-bottom: 10px;'>$message</p>
            </div>
            <div style='text-align: center; margin-top: 20px; font-size: 12px; color: #777;'>
                <p>&copy; " . date('Y') . " AIRAAB. Todos los derechos reservados.</p>
                <p><a href='https://ai-raab.com' style='color: #00274c; text-decoration: none;'>Visita nuestro sitio web</a></p>
            </div>
        </div>
    </body>
    </html>";

    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); // Using SMTP.
        // $mail->SMTPDebug = 1;
        $mail->SMTPAuth = false; // Enables SMTP authentication.
        $mail->Host = "localhost"; // GoDaddy support said to use localhost
        $mail->Port = 25;
        $mail->SMTPSecure = 'none';

        //havent read yet, but this made it work just fine
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom($recipient, 'Nuevo Contacto');
        $mail->addAddress($recipient, 'AIRAAB');

        $mail->Subject = $subject;
        $mail->Body = $email_content;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Asegura que los caracteres especiales se manejen correctamente

        // Intentar enviar el correo
        if ($mail->send()) {
            // Configurar un código de respuesta 200 (OK).
            http_response_code(200);
            echo "¡Muchas gracias! Tu mensaje se ha enviado con éxito, en un momento uno de nuestros especialistas se pondrá en contacto contigo.";
        } else {
            // Configurar un código de respuesta 500 (error interno del servidor).
            http_response_code(500);
            echo "¡Oops! Hubo un problema, favor de comunicarte directamente al +52 1 55 8373 5357.";
        }
    } catch (Exception $e) {
        // Configurar un código de respuesta 500 (error interno del servidor).
        http_response_code(500);
        echo "¡Oops! Hubo un problema, favor de comunicarte directamente al +52 1 55 8373 5357.";
    }

} else {
    // No es una solicitud POST, configurar un código de respuesta 403 (prohibido).
    http_response_code(403);
    echo "Algo salió mal, por favor inténtalo nuevamente.";
}

?>
