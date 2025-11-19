<?php
require_once 'models/LoginModel.php';
require_once 'controllers/EmailController.php';
require_once 'models/UserModel.php';

// Función reutilizable para mensajes de error de registro
function mostrarErrorRegistro($motivo, $datos = []) {
    switch ($motivo) {
        case 'email_invalido':
            return '<div class="error">Email inválido.</div>';
        case 'password_invalida':
            return '<div class="error">La contraseña debe tener al menos 8 caracteres.</div>';
        case 'passwords_no_coinciden':
            return '<div class="error">Las contraseñas no coinciden.</div>';
        case 'email_existente':
            return '<div class="error">Este email ya corresponde a un usuario. <a href="?slug=login">¿Deseas loguearte?</a></div>';
        case 'error_registro':
            return '<div class="error">Error al registrar usuario.</div>';
        case 'error_email':
            return '<div class="error">Error al enviar correo de validación.</div>';
        default:
            return '<div class="error">Error en el registro.</div>';
    }
}

// Verificar si ya está logueado
if (isset($_SESSION['user'])) {
    header('Location: ?slug=panel');
    exit;
}

$palta = new Palta("register", "register");
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = LoginModel::cleanInput($_POST['nombres']);
    $email = LoginModel::cleanInput($_POST['email']);
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    if (!LoginModel::validateEmail($email)) {
        $error = mostrarErrorRegistro('email_invalido');
    } elseif (!LoginModel::validatePassword($contraseña)) {
        $error = mostrarErrorRegistro('password_invalida');
    } elseif ($contraseña !== $confirmar_contraseña) {
        $error = mostrarErrorRegistro('passwords_no_coinciden');
    } else {
        $userModel = new UserModel();
        $existingUser = $userModel->getByEmail($email);

        if ($existingUser) {
            $error = mostrarErrorRegistro('email_existente');
        } else {
            $token = LoginModel::generateToken();
            $token_action = LoginModel::generateToken();

            if ($userModel->create($token, $email, $nombres, $contraseña, $token_action)) {
                $validationUrl = APP_BASE_URL . "?slug=validate&token_action=" . $token_action;
                $subject = "Valida tu cuenta en " . APP_NAME;
                $message = EmailController::generateEmailMessage(
                    "Bienvenido a " . APP_NAME,
                    "Hola $nombres,<br><br>Gracias por registrarte. Para activar tu cuenta, haz clic en el siguiente enlace:",
                    true,
                    "Click aquí para activar tu usuario",
                    $validationUrl
                );

                if (EmailController::sendEmail($email, $subject, $message)) {
                    $success = '<div class="success">¡Registro exitoso! Revisa tu correo para validar tu cuenta.</div>';
                } else {
                    $error = mostrarErrorRegistro('error_email');
                }
            } else {
                $error = mostrarErrorRegistro('error_registro');
            }
        }
    }
}

$palta->assign([
    'ERROR_MESSAGE' => $error,
    'SUCCESS_MESSAGE' => $success,
    'TITLE' => 'Registro - ' . APP_NAME,
    'HEADER_TITLE' => 'Crear Cuenta',
    'HEADER_SUBTITLE' => '<p>Regístrate para acceder al monitoreo meteorológico</p>',
    "APP_SECTION" => "register",
]);
$palta->printToScreen();
?>