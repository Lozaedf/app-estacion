<?php
require_once 'models/LoginModel.php';
require_once 'models/UserModel.php';
require_once 'controllers/EmailController.php';

// Función reutilizable para generar contenido HTML de bloqueo
function generarContenidoBloqueo($tipo) {
    switch ($tipo) {
        case 'bloqueo_exitoso':
            return '
                <div class="blocked-container">
                    <div class="blocked-icon">🔒</div>
                    <h2 class="blocked-title">Cuenta Bloqueada</h2>
                    <p class="blocked-message">
                        usuario bloqueado, revise su correo electrónico
                    </p>
                    <a href="?slug=login" class="btn-login">Volver al Login</a>
                </div>
            ';
        case 'token_invalido':
            return '
                <div class="blocked-container">
                    <div class="blocked-icon">❌</div>
                    <h2 class="blocked-title">Token Inválido</h2>
                    <p class="blocked-message">
                        El token no corresponde a un usuario
                    </p>
                    <a href="?slug=login" class="btn-login">Volver al Login</a>
                </div>
            ';
        default:
            return '';
    }
}

// Función reutilizable para procesar el bloqueo
function procesarBloqueoUsuario($token, $userModel) {
    $user = $userModel->getByToken($token);

    if (!$user) {
        return generarContenidoBloqueo('token_invalido');
    }

    // Bloquear al usuario
    $userModel->block($token);

    // Generar token_action para reset de contraseña
    $token_action = LoginModel::generateToken();

    // Establecer token de recuperación después del bloqueo
    $userModel->setRecoveryTokenAfterBlock($token, $token_action);

    // Enviar email notificando el bloqueo
    $resetUrl = APP_BASE_URL . "?slug=reset&token_action=" . $token_action;
    $subject = "Tu cuenta ha sido bloqueada - " . APP_NAME;
    $message = EmailController::generateEmailMessage(
        "Cuenta Bloqueada por Seguridad",
        "Hola {$user['nombres']},<br><br>
        Tu cuenta ha sido bloqueada por motivos de seguridad.<br><br>
        Si solicitaste este bloqueo, puedes restablecer tu contraseña haciendo clic en el botón de abajo.
        Si no solicitaste esto, por favor contacta con soporte inmediatamente.",
        true,
        "Click aquí para cambiar contraseña",
        $resetUrl
    );

    EmailController::sendEmail($user['email'], $subject, $message);

    return generarContenidoBloqueo('bloqueo_exitoso');
}

// Verificar si se proporcionó token
if (!isset($_GET['token'])) {
    header('Location: ?slug=login');
    exit;
}

$token = $_GET['token'];
$userModel = new UserModel();
$content = procesarBloqueoUsuario($token, $userModel);

$palta = new Palta("blocked", "blocked");
$palta->assign([
    'VALIDATION_CONTENT' => $content,
    'TITLE' => 'Cuenta Bloqueada - ' . APP_NAME,
    'HEADER_TITLE' => 'Cuenta Bloqueada',
    'HEADER_SUBTITLE' => '<p>Por seguridad, tu cuenta ha sido bloqueada</p>',
    "APP_SECTION" => "blocked",
]);
$palta->printToScreen();
?>