<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

// Solo procesar solicitudes POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los campos del formulario y eliminar los espacios en blanco.
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $product = strip_tags(trim($_POST["product"]));
    $product = str_replace(array("\r","\n"), array(" "," "), $product);

    $mainproduct = strip_tags(trim($_POST["mainproduct"]));
    $mainproduct = str_replace(array("\r","\n"), array(" "," "), $mainproduct);

    $language = strip_tags(trim($_POST["language"]));
    $language = str_replace(array("\r","\n"), array(" "," "), $language);

    $message = trim($_POST["message"]);

    // Verificar que los datos se hayan enviado al procesador de correos.
    if (empty($product) OR empty($message) OR empty($language) OR empty($mainproduct) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Configurar un código de respuesta 400 (solicitud incorrecta) y salir.
        http_response_code(400);
        echo "Por favor completa el formulario e inténtalo de nuevo.";
        exit;
    }

    // Configurar la dirección de correo del destinatario.
    $recipient = "contacto@ai-raab.com";

    // Configurar el asunto del correo.
    $subject = "Solicitud de cotización para $product";

    // Construir el contenido HTML del correo.
    $email_content = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body style='font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;'>
        <div class='container' style='width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
            <div class='header' style='text-align: center;
                margin-bottom: 20px;'>
                <img style='max-width: 150px;' src='https://ai-raab.com/assets/images/AIRaab_MainLogo.webp' alt='AIRAAB'>
            </div>
            <div class='content' style='line-height: 1.6;'>
                <h2 style='color: #00274c;
                margin-bottom: 20px;'>Solicitud de Cotización</h2>
                <p style='margin-bottom: 10px;'><strong>Correo Electrónico:</strong> $email</p>
                <p style='margin-bottom: 10px;'><strong>Sección:</strong> $mainproduct</p>
                <p style='margin-bottom: 10px;'><strong>Idioma:</strong> $language</p>
                <p style='margin-bottom: 10px;'><strong>Producto:</strong> $product</p>
                <p style='margin-bottom: 10px;'><strong>Mensaje:</strong></p>
                <p style='margin-bottom: 10px;'>$message</p>
            </div>
            <div class='footer' style='text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: #777;'>
                <p style='margin-bottom: 10px;'>&copy; " . date('Y') . " AIRAAB. Todos los derechos reservados.</p>
                <p style='margin-bottom: 10px;'><a style='color: #00274c;
                text-decoration: none;' href='https://ai-raab.com'>Visita nuestro sitio web</a></p>
            </div>
        </div>
    </body>
    </html>";

    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); // Using SMTP.
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

        // Configuración del correo
        $mail->setFrom($recipient, 'Solicitud de Cotización');
        $mail->addAddress($recipient, 'AIRAAB');

        $mail->Subject = $subject;
        $mail->Body = $email_content;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Asegura que los caracteres especiales se manejen correctamente

        // Intentar enviar el correo
        if ($mail->send()) {
            // Configurar un código de respuesta 200 (OK).
            http_response_code(200);
            echo "¡Gracias! Tu solicitud de cotización ha sido enviada con éxito.";
        } else {
            // Configurar un código de respuesta 500 (error interno del servidor).
            http_response_code(500);
            echo "¡Oops! Hubo un problema al enviar tu solicitud. Por favor, intenta de nuevo más tarde.";
        }
    } catch (Exception $e) {
        // Configurar un código de respuesta 500 (error interno del servidor).
        http_response_code(500);
        echo "¡Oops! Hubo un problema al enviar tu solicitud. Por favor, intenta de nuevo más tarde.";
    }

} else {
    // No es una solicitud POST, configurar un código de respuesta 403 (prohibido).
    http_response_code(403);
    echo "Algo salió mal. Por favor, intenta de nuevo.";
}

?>
