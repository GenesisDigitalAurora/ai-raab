<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
                $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $number = trim($_POST["number"]);
        $company = trim($_POST["company"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($number) OR empty($company) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "contact@ai-raab.com";

        // Set the email company.
        $company = "New contact from $name";

        // Build the email content.
        $email_content = "Your name: $name\n";
        $email_content .= "Email Address: $email\n\n";
        $email_content .= "Phone number:\n$number\n";
        $email_content .= "Subject:\n$company\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $company, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Muchas gracias! Tu mesaje se ha enviado con éxito, en un momento uno de nuestros especialistas se pondrá en contacto contigo.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Hubo un problema, favor de comunicarte directamente a 52 1 55 8373 5357.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Algo salío mal, porfavor intentalo nuvamente";
    }

?>

