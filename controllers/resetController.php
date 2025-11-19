<?php
require_once 'models/LoginModel.php';
require_once 'controllers/EmailController.php';
require_once 'models/UserModel.php';

// Función reutilizable para verificar si está logueado
function redirectIfLoggedIn() {
    if (isset($_SESSION['user'])) {
        header('Location: ?slug=panel');
        exit;
    }
}

// Función reutilizable para mostrar errores de reset
function mostrarErrorReset($motivo) {
    switch ($motivo) {
        case 'passwords_no_coinciden':
            return '<div class="error">Las contraseñas no coinciden.</div>';
        case 'password_invalida':
            return '<div class="error">La contraseña debe tener al menos 8 caracteres.</div>';
        case 'token_invalido':
            return '<div class="error">El enlace de recuperación es inválido o ha expirado.</div>';
        case 'acceso_denegado':
            return '<div class="error">Acceso denegado. Se requiere token de recuperación.</div>';
        default:
            return '<div class="error">Error en el restablecimiento de contraseña.</div>';
    }
}

// Función reutilizable para enviar email de notificación de reset
function enviarNotificacionReset($user) {
    $userInfo = LoginModel::getUserAgentInfo();
    $ip = LoginModel::getUserIP();
    $blockUrl = APP_BASE_URL . "?slug=blocked&token=" . $user['token'];

    $subject = "Contraseña Restablecida - " . APP_NAME;
    $message = EmailController::generateEmailMessage(
        "Contraseña Restablecida Exitosamente",
        "Hola {$user['nombres']},<br><br>
        Tu contraseña ha sido restablecida exitosamente:<br><br>
        <strong>IP:</strong> $ip<br>
        <strong>Navegador:</strong> {$userInfo['browser']}<br>
        <strong>Sistema Operativo:</strong> {$userInfo['os']}<br><br>
        Si no realizaste esta acción, por favor bloquea tu cuenta inmediatamente.",
        true,
        "No fui yo, bloquear cuenta",
        $blockUrl
    );

    EmailController::sendEmail($user['email'], $subject, $message);
}

// Verificar si ya está logueado
redirectIfLoggedIn();

$palta = new Palta("reset", "reset");
$error = '';
$success = '';
$resetToken = '';

if (!isset($_GET['token_action'])) {
    $error = mostrarErrorReset('acceso_denegado');
} else {
    $resetToken = $_GET['token_action'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $contraseña = $_POST['contraseña'];
        $confirmar_contraseña = $_POST['confirmar_contraseña'];

        if ($contraseña !== $confirmar_contraseña) {
            $error = mostrarErrorReset('passwords_no_coinciden');
        } elseif (!LoginModel::validatePassword($contraseña)) {
            $error = mostrarErrorReset('password_invalida');
        } else {
            $userModel = new UserModel();
            if ($userModel->resetPassword($resetToken, $contraseña)) {
                // Obtener datos del usuario para el email
                $user = $userModel->getByTokenAction($resetToken);

                if ($user) {
                    enviarNotificacionReset($user);
                }

                // Redirigir a login
                header('Location: ?slug=login');
                exit;
            } else {
                $error = mostrarErrorReset('token_invalido');
            }
        }
    }
}

$palta->assign([
    'ERROR_MESSAGE' => $error,
    'SUCCESS_MESSAGE' => $success,
    'RESET_TOKEN' => $resetToken,
    'TITLE' => 'Restablecer Contraseña - ' . APP_NAME,
    'HEADER_TITLE' => 'Restablecer Contraseña',
    'HEADER_SUBTITLE' => '<p>Ingresa tu nueva contraseña</p>',
    "APP_SECTION" => "reset",
]);
$palta->printToScreen();
?>