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

// Función reutilizable para mostrar errores de recuperación
function mostrarErrorRecuperacion($motivo) {
    switch ($motivo) {
        case 'email_invalido':
            return '<div class="error">Email inválido.</div>';
        case 'email_no_registrado':
            return '<div class="error">El email no se encuentra registrado. <a href="?slug=register">¿Deseas registrarte?</a></div>';
        case 'error_procesamiento':
            return '<div class="error">Error al procesar la solicitud.</div>';
        default:
            return '<div class="error">Error en la recuperación de contraseña.</div>';
    }
}

// Función reutilizable para procesar la recuperación de contraseña
function procesarRecuperacionPassword($email, $userModel) {
    $user = $userModel->getByEmail($email);

    if (!$user) {
        return ['success' => false, 'message' => mostrarErrorRecuperacion('email_no_registrado')];
    }

    $token_action = LoginModel::generateToken();

    if (!$userModel->setRecoveryToken($user['token'], $token_action)) {
        return ['success' => false, 'message' => mostrarErrorRecuperacion('error_procesamiento')];
    }

    $resetUrl = APP_BASE_URL . "?slug=reset&token_action=" . $token_action;
    $subject = "Recuperación de Contraseña - " . APP_NAME;
    $message = EmailController::generateEmailMessage(
        "Recuperación de Contraseña",
        "Hola {$user['nombres']},<br><br>Recibimos una solicitud para restablecer tu contraseña. Haz clic en el siguiente enlace:",
        true,
        "Click aquí para restablecer contraseña",
        $resetUrl
    );

    if (EmailController::sendEmail($email, $subject, $message)) {
        return ['success' => true, 'message' => '<div class="success">Se ha enviado un correo con instrucciones para recuperar tu contraseña.</div>'];
    } else {
        return ['success' => false, 'message' => mostrarErrorRecuperacion('error_procesamiento')];
    }
}

// Verificar si ya está logueado
redirectIfLoggedIn();

$palta = new Palta("recuperar", "recuperar");
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = LoginModel::cleanInput($_POST['email']);

    if (!LoginModel::validateEmail($email)) {
        $error = mostrarErrorRecuperacion('email_invalido');
    } else {
        $userModel = new UserModel();
        $result = procesarRecuperacionPassword($email, $userModel);

        if ($result['success']) {
            $success = $result['message'];
        } else {
            $error = $result['message'];
        }
    }
}

$palta->assign([
    'ERROR_MESSAGE' => $error,
    'SUCCESS_MESSAGE' => $success,
    'TITLE' => 'Recuperar Contraseña - ' . APP_NAME,
    'HEADER_TITLE' => 'Recuperar Contraseña',
    'HEADER_SUBTITLE' => '<p>Recibe un enlace para restablecer tu contraseña</p>',
    "APP_SECTION" => "recuperar",
]);
$palta->printToScreen();
?>