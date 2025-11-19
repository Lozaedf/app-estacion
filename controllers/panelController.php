<?php
require_once(__DIR__ . "/../env.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: ?slug=login');
    exit;
}

// Función reutilizable para obtener estaciones
function obtenerEstaciones() {
    $api_local_url = APP_BASE_URL . "api/datos.php";
    $context = stream_context_create(['http' => ['timeout' => 10, 'method' => 'GET']]);
    $list_url = $api_local_url . "?mode=list-stations";
    $response = file_get_contents($list_url, false, $context);

    $stations = [];
    if ($response !== false) {
        $data = json_decode($response);
        if ($data && is_array($data)) {
            foreach ($data as $station) {
                $stations[] = [
                    "chipid" => $station->chipid,
                    "apodo" => $station->apodo,
                    "ubicacion" => $station->ubicacion,
                    "visitas" => $station->visitas,
                    "status" => $station->status,
                    "dias_inactivo" => $station->dias_inactivo
                ];
            }
        }
    }
    return $stations;
}

// Función reutilizable para generar HTML de estación
function generarHtmlEstacion($station) {
    $card_class = 'station-card';
    if ($station['dias_inactivo'] > 0) {
        $card_class .= ' station-card--inactive';
    }

    return '
        <div class="' . $card_class . '" onclick="goToDetail(\'' . htmlspecialchars($station['chipid']) . '\')">
            <div class="station-header">
                <div class="station-nickname">' . htmlspecialchars($station['apodo']) . '</div>
                <div class="station-chipid">ID: ' . htmlspecialchars($station['chipid']) . '</div>
            </div>
            <div class="station-body">
                <div class="station-location">
                    <span class="location-icon">📍</span>
                    <span>' . htmlspecialchars($station['ubicacion']) . '</span>
                </div>
                <div class="station-visits">
                    <span class="visits-count">' . number_format($station['visitas']) . '</span>
                    <span class="visits-label">visitas</span>
                    ' . ($station['dias_inactivo'] > 0 ? '<span class="inactivo-badge">Inactiva ' . $station['dias_inactivo'] . ' días</span>' : '') . '
                </div>
                <div class="station-status">
                    ' . ($station['status'] ? '<span class="status-indicator status-online"></span>' : '<span class="status-indicator status-offline"></span>') . '
                    <span class="status-text">' . ($station['status'] ? 'En línea' : 'Sin conexión') . '</span>
                </div>
            </div>
            <div class="station-footer">
                <span class="action-icon">📊</span>
                <span class="action-text">Ver detalles</span>
            </div>
        </div>
    ';
}

$api_local_url = APP_BASE_URL . "api/datos.php";
$context = stream_context_create(['http' => ['timeout' => 10, 'method' => 'GET']]);
$list_url = $api_local_url . "?mode=list-stations";
$response = file_get_contents($list_url, false, $context);

$stations = [];
if ($response !== false) {
	$data = json_decode($response);
	if ($data && is_array($data)) {
		foreach ($data as $station) {
			$stations[] = [
				"chipid" => $station->chipid,
				"apodo" => $station->apodo,
				"ubicacion" => $station->ubicacion,
				"visitas" => $station->visitas,
				"status" => $station->status,
				"dias_inactivo" => $station->dias_inactivo
			];
		}
	}
}

// Generar HTML para Palta
$stations_html = '';
foreach ($stations as $station) {
	$card_class = 'station-card';
	if ($station['dias_inactivo'] > 0) {
		$card_class .= ' station-card--inactive';
	}

	$stations_html .= '
		<div class="' . $card_class . '" onclick="goToDetail(\'' . htmlspecialchars($station['chipid']) . '\')">
			<div class="station-header">
				<div class="station-nickname">' . htmlspecialchars($station['apodo']) . '</div>
				<div class="station-chipid">ID: ' . htmlspecialchars($station['chipid']) . '</div>
			</div>
			<div class="station-body">
				<div class="station-location">
					<span class="location-icon">📍</span>
					<span>' . htmlspecialchars($station['ubicacion']) . '</span>
				</div>
				<div class="station-visits">
					<span class="visits-count">' . number_format($station['visitas']) . '</span>
					<span class="visits-label">visitas</span>
					' . ($station['dias_inactivo'] > 0 ? '<span class="inactivo-badge">Inactiva ' . $station['dias_inactivo'] . ' días</span>' : '') . '
				</div>
				<div class="station-status">
					<span class="status-dot ' . htmlspecialchars($station['status']) . '"></span>
					<span class="status-text">' . htmlspecialchars($station['status']) . '</span>
				</div>
			</div>
		</div>';
}

$TITLE = 'Panel de Estaciones - ' . APP_NAME;
$HEADER_TITLE = 'Panel de Estaciones';
$HEADER_SUBTITLE = '<p>Listado y estado de todas las estaciones meteorológicas</p>';

$tpl = new Palta("panel", "panel");
$tpl->assign([
    'STATIONS_HTML' => $stations_html,
    'TITLE' => $TITLE,
    'HEADER_TITLE' => $HEADER_TITLE,
    'HEADER_SUBTITLE' => $HEADER_SUBTITLE,
    "APP_SECTION" => "panel"
]);
$tpl->printToScreen();
?>