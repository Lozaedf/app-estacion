<?php
require_once(__DIR__ . "/../env.php");
require_once 'models/UserModel.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: ?slug=login');
    exit();
}

// Función reutilizable para validar parámetros GET
function validarParametro($parametro) {
    return isset($_GET[$parametro]) ? trim($_GET[$parametro]) : '';
}

/**
 * Función reutilizable para redirigir con validación
 */
function redirigir($destino) {
    header('Location: ' . $destino);
    exit;
}

$chipid = validarParametro('chipid');

if (empty($chipid)) {
    redirigir('?slug=panel');
}

// Validar formato del chipid (solo alfanumérico)
if (!preg_match('/^[a-zA-Z0-9]+$/', $chipid)) {
    redirigir('?slug=panel');
}

// Asignar las variables específicas de esta página
$palta->assign([
    'CHIPID' => htmlspecialchars($chipid),
    'HEAD_EXTRA' => '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>',
    'TITLE' => 'Detalle de Estación - ' . APP_NAME,
    'HEADER_TITLE' => 'Detalle de Estación',
    'HEADER_SUBTITLE' => '<p>Información detallada y gráficos meteorológicos</p>',
    'SHOW_PANEL_BTN' => '<a href="?slug=panel" class="nav-btn panel-btn">📊 Panel</a>'
]);

$palta->printToScreen();
?>