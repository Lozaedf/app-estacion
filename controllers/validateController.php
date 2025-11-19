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

// Función reutilizable para generar contenido HTML de validación
function generarContenidoValidacion($tipo, $user = null) {
    switch ($tipo) {
        case 'ya_validada':
            return '
                <div class="error-icon">⚠️</div>
                <h3 class="validation-title">Cuenta Ya Validada</h3>
                <p class="validation-message">Esta cuenta ya ha sido validada anteriormente. Puedes iniciar sesión directamente.</p>
            ';
        case 'error_validacion':
            return '
                <div class="error-icon">❌</div>
                <h3 class="validation-title">Error de Validación</h3>
                <p class="validation-message">No se pudo validar tu cuenta. Por favor, intenta nuevamente o contacta soporte.</p>
            ';
        case 'token_invalido':
            return '
                <div class="error-icon">❌</div>
                <h3 class="validation-title">Token Inválido</h3>
                <p class="validation-message">El token no corresponde a un usuario.</p>
            ';
        case 'acceso_denegado':
            return '
                <div class="error-icon">❌</div>
                <h3 class="validation-title">Acceso Denegado</h3>
                <p class="validation-message">No se proporcionó token de validación.</p>
            ';
        case 'activacion_exitosa':
            // Enviar email de notificación
            $subject = "¡Cuenta Activada - " . APP_NAME;
            $message = EmailController::generateEmailMessage(
                "¡Bienvenido a " . APP_NAME . "!",
                "Hola {$user['nombres']},<br><br>
                ¡Tu cuenta ha sido activada exitosamente!<br><br>
                Ya puedes disfrutar de todas las funcionalidades de " . APP_NAME . ".<br><br>
                Te esperamos en nuestra plataforma.",
                false
            );
            EmailController::sendEmail($user['email'], $subject, $message);
            // Redirigir a login
            header('Location: ?slug=login');
            exit;
        default:
            return '';
    }
}

// Verificar si ya está logueado
redirectIfLoggedIn();

$palta = new Palta("validate", "validate");
$content = '';

if (isset($_GET['token_action'])) {
    $token_action = $_GET['token_action'];
    $userModel = new UserModel();
    $user = $userModel->getByTokenAction($token_action);

    if ($user) {
        if ($user['activo']) {
            $content = generarContenidoValidacion('ya_validada', $user);
        } else {
            if ($userModel->activate($user['token'])) {
                $content = generarContenidoValidacion('activacion_exitosa', $user);
            } else {
                $content = generarContenidoValidacion('error_validacion', $user);
            }
        }
    } else {
        $content = generarContenidoValidacion('token_invalido');
    }
} else {
    $content = generarContenidoValidacion('acceso_denegado');
}

$palta->assign([
    'VALIDATION_CONTENT' => $content,
    'TITLE' => 'Validación de Cuenta - ' . APP_NAME,
    'HEADER_TITLE' => 'Validación de Cuenta',
    'HEADER_SUBTITLE' => '<p>Procesando la validación de tu cuenta</p>',
    "APP_SECTION" => "validate",
]);
$palta->printToScreen();
?>