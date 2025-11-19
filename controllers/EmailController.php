<?php

class EmailController {
    public static function sendEmail($to, $subject, $message) {
        require_once __DIR__ . '/../librarys/mp-mailer/Mailer/src/PHPMailer.php';
        require_once __DIR__ . '/../librarys/mp-mailer/Mailer/src/SMTP.php';
        require_once __DIR__ . '/../librarys/mp-mailer/Mailer/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_USER, APP_NAME);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;

  
            $mail->Body = $message;

            return $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar email: " . $mail->ErrorInfo);
            return false;
        }
    }

    public static function generateEmailMessage($title, $content, $showButton = true, $buttonText = "Click aquí", $buttonUrl = null) {
        $message = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .container {
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0,0,0,0.1);
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .content {
                    margin-bottom: 20px;
                }
                .button {
                    text-align: center;
                }
                .btn {
                    background-color: #4CAF50;
                    color: white;
                    padding: 12px 24px;
                    text-decoration: none;
                    border-radius: 5px;
                    display: inline-block;
                    font-weight: bold;
                }
                .footer {
                    text-align: center;
                    color: #666;
                    font-size: 12px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>' . $title . '</h2>
                </div>
                <div class="content">
                    ' . $content . '
                </div>';

        if ($showButton && $buttonUrl) {
            $message .= '
                <div class="button">
                    <a href="' . $buttonUrl . '" class="btn">' . $buttonText . '</a>
                </div>';
        }

        $message .= '
                <div class="footer">
                    <p>Este es un mensaje automático, por favor no responder.</p>
                </div>
            </div>
        </body>
        </html>';

        return $message;
    }
}
?>