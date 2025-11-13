<?php
header("Content-Type: application/json");

// Chipids que sabemos que funcionan en la API original
$working_chipids = [
    "713630", // MattLab I
    "3973796", // MattLab II
    "11214452"  // Aeroclub La Cumbre
];

$stations = [];
$api_original_url = "https://mattprofe.com.ar/proyectos/app-estacion/datos.php";

foreach ($working_chipids as $chipid) {
    // Obtener datos actuales de cada estación
    $datos_url = $api_original_url . "?chipid=" . urlencode($chipid) . "&cant=1";

    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET'
        ]
    ]);

    $response = file_get_contents($datos_url, false, $context);

    if ($response !== false) {
        $data = json_decode($response);

        if ($data && is_array($data) && count($data) > 0) {
            $station_data = $data[0];

            // Crear objeto de estación con datos reales
            $stations[] = [
                "chipid" => $chipid,
                "apodo" => $station_data->estacion ?? "Estación " . $chipid,
                "ubicacion" => $station_data->ubicacion ?? "Ubicación desconocida",
                "temperatura" => ($station_data->temperatura ?? "N/A") . "°C",
                "humedad" => ($station_data->humedad ?? "N/A") . "%",
                "status" => "online",
                "descripcion" => "Estación meteorológica con datos en tiempo real"
            ];
        }
    }
}

echo json_encode($stations);
?>