<?php

// Solo procesar solicitudes POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los campos del formulario y eliminar los espacios en blanco.
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $product = strip_tags(trim($_POST["product"]));
    $product = str_replace(array("\r","\n"),array(" "," "),$product);
    $message = trim($_POST["message"]);

    // Verificar que los datos se hayan enviado al procesador de correos.
    if (empty($product) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Configurar un código de respuesta 400 (solicitud incorrecta) y salir.
        http_response_code(400);
        echo "Por favor completa el formulario e inténtalo de nuevo.";
        exit;
    }

    // Configurar la dirección de correo del destinatario.
    $recipient = "contacto@ai-raab.com";

    // Configurar el asunto del correo.
    $subject = "Solicitud de cotización para $product";

    // Construir el contenido del correo.
    $email_content = "Correo Electrónico: $email\n";
    $email_content .= "Producto: $product\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // Construir los encabezados del correo.
    $email_headers = "From: $email";

    // Enviar el correo.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Configurar un código de respuesta 200 (OK).
        http_response_code(200);
        echo "¡Gracias! Tu solicitud de cotización ha sido enviada con éxito.";
    } else {
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
