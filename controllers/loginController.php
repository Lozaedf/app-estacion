<?php
require_once 'models/LoginModel.php';
require_once 'models/UserModel.php';
require_once 'controllers/EmailController.php';

/**
 * Función reutilizable para enviar email de alerta de seguridad
 */
function enviarEmailAlerta($user, $motivo) {
    $userInfo = LoginModel::getUserAgentInfo();
    $ip = LoginModel::getUserIP();
    $blockUrl = APP_BASE_URL . "?slug=blocked&token=" . $user['token'];

    // Asunto y mensaje según el motivo
    switch ($motivo) {
        case 'bloqueado':
            $subject = "Intento de acceso con cuenta bloqueada - " . APP_NAME;
            $titulo = "Intento de Acceso Detectado";
            $descripcion = "Se detectó un intento de acceso a tu cuenta que está bloqueada";
            break;
        case 'password_incorrecta':
            $subject = "Intento de acceso con contraseña incorrecta - " . APP_NAME;
            $titulo = "Intento de Acceso Detectado";
            $descripcion = "Se detectó un intento de acceso a tu cuenta con contraseña incorrecta";
            break;
        case 'login_exitoso':
            $subject = "Inicio de sesión en " . APP_NAME;
            $titulo = "Inicio de Sesión Detectado";
            $descripcion = "Se ha detectado un inicio de sesión en tu cuenta";
            break;
        default:
            $subject = "Alerta de seguridad - " . APP_NAME;
            $titulo = "Alerta de Seguridad";
            $descripcion = "Se detectó una actividad inusual en tu cuenta";
    }

    $message = EmailController::generateEmailMessage(
        $titulo,
        "Hola {$user['nombres']},<br><br>
        {$descripcion}:<br><br>
        <strong>IP:</strong> $ip<br>
        <strong>Navegador:</strong> {$userInfo['browser']}<br>
        <strong>Sistema Operativo:</strong> {$userInfo['os']}<br><br>
        " . ($motivo === 'login_exitoso'
            ? 'Si fuiste tú, puedes ignorar este mensaje. Si no reconoces esta actividad, por favor bloquea tu cuenta inmediatamente.'
            : 'Si no reconoces esta actividad, por favor bloquea tu cuenta inmediatamente.'),
        true,
        "No fui yo, bloquear cuenta",
        $blockUrl
    );

    return EmailController::sendEmail($user['email'], $subject, $message);
}

/**
 * Función reutilizable para mostrar mensajes de error en login
 */
function mostrarErrorLogin($motivo) {
    switch ($motivo) {
        case 'bloqueado':
            return '<div class="error">Su usuario está bloqueado, revise su casilla de correo.</div>';
        case 'password_incorrecta':
            return '<div class="error">credenciales no válidas</div>';
        case 'no_activo':
            return '<div class="error">Tu cuenta aún no ha sido validada. Revisa tu correo electrónico.</div>';
        case 'usuario_invalido':
            return '<div class="error">credenciales no válidas</div>';
        default:
            return '<div class="error">Error de inicio de sesión</div>';
    }
}

// Verificar si ya está logueado
if (isset($_SESSION['user'])) {
    header('Location: ?slug=panel');
    exit;
}

$palta = new Palta("login", "login");
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = LoginModel::cleanInput($_POST['email']);
    $contraseña = $_POST['contraseña'];

    $userModel = new UserModel();
    $user = $userModel->getByEmail($email);

    if ($user && password_verify($contraseña, $user['contraseña'])) {
        if ($user['bloqueado'] || $user['recuperado']) {
            // Enviar email de alerta y mostrar error
            enviarEmailAlerta($user, 'bloqueado');
            $error = mostrarErrorLogin('bloqueado');
        } elseif (!$user['activo']) {
            $error = mostrarErrorLogin('no_activo');
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'nombres' => $user['nombres'],
                'token' => $user['token']
            ];

            // Enviar email de notificación de inicio de sesión
            enviarEmailAlerta($user, 'login_exitoso');

            // Obtener primera estación disponible para redirección directa a detalle
            $api_local_url = APP_BASE_URL . "api/datos.php";
            $context = stream_context_create(['http' => ['timeout' => 10, 'method' => 'GET']]);
            $list_url = $api_local_url . "?mode=list-stations";
            $response = file_get_contents($list_url, false, $context);

            $default_chipid = '713630'; // Estación por defecto si no hay conexión
            if ($response !== false) {
                $data = json_decode($response);
                if ($data && is_array($data) && count($data) > 0) {
                    $default_chipid = $data[0]->chipid;
                }
            }

            header('Location: ?slug=detalle&chipid=' . $default_chipid);
            exit;
        }
    } else {
        // Si el usuario existe pero la contraseña es incorrecta, enviar email
        if ($user) {
            enviarEmailAlerta($user, 'password_incorrecta');
        }

        $error = mostrarErrorLogin('password_incorrecta');
    }
}

$palta->assign([
    'ERROR_MESSAGE' => $error,
    'TITLE' => 'Login - ' . APP_NAME,
    'HEADER_TITLE' => 'Iniciar Sesión',
    'HEADER_SUBTITLE' => '<p>Accede a tu cuenta para monitorear las estaciones</p>',
    "APP_SECTION" => $section,
    ]);
	
$palta->printToScreen();
?>