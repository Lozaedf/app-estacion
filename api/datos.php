<?php
header("Content-Type: application/json");

$chipid = isset($_GET['chipid']) ? $_GET['chipid'] : '';
$cantidad = isset($_GET['cant']) ? (int)$_GET['cant'] : 7;
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
$api_original_url = "https://mattprofe.com.ar/proyectos/app-estacion/datos.php";

// Lista de estaciones con visitas
if ($mode === "list-stations") {
    $working_chipids = ["713630", "3973796", "11214452"];
    $stations_list = [];
    $simulated_visits = [
        "713630" => rand(3400, 3600),
        "3973796" => rand(2100, 2300),
        "11214452" => rand(1800, 2000)
    ];

    foreach ($working_chipids as $chipid) {
        $datos_url = $api_original_url . "?chipid=" . urlencode($chipid) . "&cant=1";
        $context = stream_context_create(['http' => ['timeout' => 5, 'method' => 'GET']]);
        $response = file_get_contents($datos_url, false, $context);

        if ($response !== false) {
            $data = json_decode($response);
            if ($data && is_array($data) && count($data) > 0) {
                $station_data = $data[0];
                $dias_inactivo = (rand(1, 100) <= 5) ? rand(1, 3) : 0;

                $stations_list[] = [
                    "chipid" => $chipid,
                    "apodo" => $station_data->estacion ?? "Estación " . $chipid,
                    "ubicacion" => $station_data->ubicacion ?? "Ubicación desconocida",
                    "visitas" => $simulated_visits[$chipid],
                    "dias_inactivo" => $dias_inactivo,
                    "status" => $dias_inactivo > 0 ? "inactiva" : "online"
                ];
            }
        }
    }

    echo json_encode($stations_list);
    exit();
}

// Validar chipid para otros modos
if (empty($chipid)) {
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(array("error" => "Se requiere chipid"));
    exit;
}

// Incrementar visitas
if ($mode === "visit-station") {
    $visit_url = $api_original_url . "?chipid=" . urlencode($chipid) . "&mode=visit-station";
    $context = stream_context_create(['http' => ['timeout' => 10, 'method' => 'GET']]);
    $response = file_get_contents($visit_url, false, $context);

    if ($response !== false) {
        echo $response;
    } else {
        echo json_encode(array("error" => "No se pudo conectar con la API original"));
    }
    exit();
}

// Proxy simple para datos meteorológicos
$datos_url = $api_original_url . "?chipid=" . urlencode($chipid) . "&cant=" . $cantidad;
$context = stream_context_create(['http' => ['timeout' => 10, 'method' => 'GET']]);
$response = file_get_contents($datos_url, false, $context);

if ($response !== false) {
    echo $response;
} else {
    header("HTTP/1.0 502 Bad Gateway");
    echo json_encode(array("error" => "No se pudo conectar con la API original"));
}
?>