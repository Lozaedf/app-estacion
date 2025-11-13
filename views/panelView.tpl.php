<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estaciones - {{ APP_NAME }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: {{ COLOR_FONDO_PRINCIPAL }};
            color: {{ COLOR_TEXTO_PRINCIPAL }};
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: {{ COLOR_HEADER_FONDO }};
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .back-link {
            display: inline-block;
            background-color: {{ COLOR_ACENTO_SECUNDARIO }};
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 25px;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background-color: #229954;
            transform: translateY(-2px);
        }

        .stations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .station-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .station-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .station-card--inactive {
            opacity: 0.7;
            border: 2px dashed #e74c3c;
        }

        .station-card--inactive:hover {
            opacity: 0.8;
        }

        .station-header {
            background: linear-gradient(135deg, {{ COLOR_ACENTO_CLIMA }}, {{ COLOR_ACENTO_ALERTA }});
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .station-nickname {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .station-chipid {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .station-body {
            padding: 1.5rem;
        }

        .station-location {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: {{ COLOR_TEXTO_SECUNDARIO }};
        }

        .location-icon {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        .station-visits {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            gap: 0.5rem;
        }

        .visits-count {
            font-size: 1.5rem;
            font-weight: bold;
            color: {{ COLOR_ACENTO_CLIMA }};
        }

        .visits-label {
            font-size: 0.9rem;
            color: {{ COLOR_TEXTO_SECUNDARIO }};
        }

        .inactivo-badge {
            background-color: #e74c3c;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .weather-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background: {{ COLOR_FONDO_PRINCIPAL }};
            border-radius: 8px;
        }

        .weather-icon {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        .weather-value {
            font-weight: bold;
            color: {{ COLOR_TEXTO_PRINCIPAL }};
        }

        .station-status {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .status-dot.online {
            background-color: #27ae60;
        }

        .status-dot.offline {
            background-color: #e74c3c;
        }

        .status-text {
            text-transform: uppercase;
        }

        .online {
            background-color: #d5f4e6;
            color: #27ae60;
        }

        .offline {
            background-color: #fdf2f2;
            color: #e74c3c;
        }

        .footer {
            background-color: {{ COLOR_FONDO_PRINCIPAL }};
            color: {{ COLOR_TEXTO_SECUNDARIO }};
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🌡️ Panel de Estaciones Meteorológicas</h1>
            <p>Monitoreo en tiempo real desde múltiples ubicaciones</p>
        </div>
    </div>

    <div class="container">
        <a href="?slug=landing" class="back-link">← Volver al Inicio</a>

        <div id="stations-container" class="stations-grid">
            <!-- Estaciones generadas desde el controlador -->
            {{ STATIONS_HTML }}
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; {{ APP_NAME }} - Desarrollado por {{ APP_AUTHOR }}</p>
        </div>
    </div>

    <script type="text/javascript">
        function goToDetail(chipid) {
            window.location.href = `?slug=detalle&chipid=${chipid}`;
        }
    </script>
</body>
</html>