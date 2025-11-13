<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Estación - {{ APP_NAME }}</title>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            max-width: 1000px;
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

        .station-detail {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .station-header {
            background: linear-gradient(135deg, {{ COLOR_ACENTO_CLIMA }}, #5dade2);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .station-nickname {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .station-chipid {
            font-size: 1rem;
            opacity: 0.9;
            font-family: monospace;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: inline-block;
        }

        .station-body {
            padding: 2rem;
        }

        .station-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background-color: {{ COLOR_FONDO_PRINCIPAL }};
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .info-section h3 {
            color: {{ COLOR_ACENTO_CLIMA }};
            margin-bottom: 1rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-content {
            font-size: 1.1rem;
            color: {{ COLOR_TEXTO_SECUNDARIO }};
            line-height: 1.6;
        }

        .loading {
            text-align: center;
            padding: 3rem;
            font-size: 1.2rem;
            color: {{ COLOR_TEXTO_SECUNDARIO }};
        }

        .error-message {
            background: #e74c3c;
            color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            margin: 2rem 0;
        }

        .weather-data {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .weather-header {
            background: linear-gradient(135deg, {{ COLOR_ACENTO_CLIMA }}, #5dade2);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .weather-header h3 {
            font-size: 1.5rem;
        }

        .weather-content {
            padding: 2rem;
        }

        .weather-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .weather-item:last-child {
            border-bottom: none;
        }

        .weather-label {
            font-weight: bold;
            color: {{ COLOR_TEXTO_PRINCIPAL }};
            font-size: 1.1rem;
        }

        .weather-value {
            color: {{ COLOR_TEXTO_SECUNDARIO }};
            font-size: 1.1rem;
        }

        .footer {
            background-color: {{ COLOR_FOOTER_FONDO }};
            color: {{ COLOR_FOOTER_TEXTO }};
            text-align: center;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .station-info {
                grid-template-columns: 1fr;
            }

            .station-nickname {
                font-size: 1.5rem;
            }
        }

        /* Chart Styles */
        .charts-container {
            margin-top: 3rem;
        }

        .chart-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .chart-header h3 {
            color: {{ COLOR_TEXTO_PRINCIPAL }};
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .chart-controls {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .chart-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            color: white;
        }

        .chart-btn.active {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .chart-btn.temp {
            background: linear-gradient(135deg, {{ COLOR_ACENTO_CLIMA }}, #ff6b6b);
        }

        .chart-btn.humidity {
            background: linear-gradient(135deg, #00bbf9, #0084d6);
        }

        .chart-btn.wind {
            background: linear-gradient(135deg, #e0fbfc, #a8dadc);
        }

        .chart-btn.pressure {
            background: linear-gradient(135deg, #6ee55d, #4caf50);
        }

        .chart-btn.fire {
            background: linear-gradient(135deg, {{ COLOR_ACENTO_ALERTA }}, #ff6b6b);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            height: 400px;
            position: relative;
        }

        .chart-canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .chart-section {
            display: none;
        }

        .chart-section.active {
            display: block;
        }

        .last-update {
            text-align: center;
            color: {{ COLOR_TEXTO_SECUNDARIO }};
            font-size: 0.9rem;
            margin-top: 1rem;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Detalle de Estación</h1>
        </div>
    </div>

    <div class="container">
        <a href="?slug=panel" class="back-link">← Volver al Panel</a>

        <div id="loading" class="loading">
            <div>🌡️ Cargando detalles de la estación...</div>
        </div>

        <div id="error-message" class="error-message" style="display: none;">
            <div>❌ No se pudieron cargar los detalles de la estación. Por favor, intenta nuevamente.</div>
        </div>

        <div id="station-detail" style="display: none;">
            <div class="station-detail">
                <div class="station-header">
                    <div class="station-nickname" id="station-nickname">Estación</div>
                    <div class="station-chipid" id="station-chipid">ID: {{ CHIPID }}</div>
                </div>
                <div class="station-body">
                    <div class="station-info">
                        <div class="info-section">
                            <h3>📍 Ubicación</h3>
                            <div class="info-content" id="station-location">
                                Cargando ubicación...
                            </div>
                        </div>
                        <div class="info-section">
                            <h3>👁️ Visitas</h3>
                            <div class="info-content" id="station-visits">
                                Cargando visitas...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weather-data">
                <div class="weather-header">
                    <h3>🌡️ Datos Meteorológicos</h3>
                </div>
                <div class="weather-content" id="weather-content">
                    <!-- Los datos meteorológicos se cargarán dinámicamente aquí -->
                </div>
            </div>

            <!-- Gráficos Chart.js -->
            <div class="charts-container">
                <div class="chart-header">
                    <h3>📊 Gráficos Meteorológicos</h3>
                    <p>Visualización histórica de datos (actualizado cada 60 segundos)</p>
                </div>

                <div class="chart-controls">
                    <button class="chart-btn temp active" onclick="showChart('temperature')">
                        🌡️ Temperatura
                    </button>
                    <button class="chart-btn humidity" onclick="showChart('humidity')">
                        💧 Humedad
                    </button>
                    <button class="chart-btn wind" onclick="showChart('wind')">
                        💨 Viento
                    </button>
                    <button class="chart-btn pressure" onclick="showChart('pressure')">
                        📊 Presión
                    </button>
                    <button class="chart-btn fire" onclick="showChart('fire')">
                        🔥 Riesgo de Incendio
                    </button>
                </div>

                <!-- Gráfico de Temperatura -->
                <div class="chart-section active" id="chart-temperature">
                    <div class="chart-container">
                        <canvas id="temperature-chart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Humedad -->
                <div class="chart-section" id="chart-humidity">
                    <div class="chart-container">
                        <canvas id="humidity-chart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Viento -->
                <div class="chart-section" id="chart-wind">
                    <div class="chart-container">
                        <canvas id="wind-chart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Presión -->
                <div class="chart-section" id="chart-pressure">
                    <div class="chart-container">
                        <canvas id="pressure-chart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Riesgo de Incendio -->
                <div class="chart-section" id="chart-fire">
                    <div class="chart-container">
                        <canvas id="fire-chart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <div class="last-update" id="last-update">
                    Última actualización: Cargando...
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; {{ APP_NAME }} - Desarrollado por {{ APP_AUTHOR }}</p>
        </div>
    </div>

    <script type="text/javascript">
        const chipid = '{{ CHIPID }}';

        document.addEventListener('DOMContentLoaded', () => {
            loadStationDetail();
        });

        async function loadStationDetail() {
            try {
                // Obtener TODOS los datos directamente de la API - sin archivos JSON locales
                const weatherResponse = await fetch(`api/datos.php?chipid=${chipid}&cant=1`);
                const weatherData = await weatherResponse.json();

                if (!weatherData || weatherData.length === 0) {
                    throw new Error('No hay datos disponibles para esta estación');
                }

                // 100% datos de la API - sin hardcodeo, sin JSON locales
                const weatherInfo = weatherData[0];
                const station = {
                    chipid: chipid,
                    apodo: weatherInfo.estacion || `Estación ${chipid}`,        // Nombre desde API
                    ubicacion: weatherInfo.ubicacion || 'Ubicación desconocida', // Ubicación desde API
                    temperatura: weatherInfo.temperatura + '°C',                // Desde API
                    sensacion_termica: weatherInfo.sensacion + '°C',           // Desde API
                    humedad: weatherInfo.humedad + '%',                         // Desde API
                    presion: weatherInfo.presion + ' hPa',                     // Desde API
                    viento: weatherInfo.viento + ' Km/h',                       // Desde API
                    direccion_viento: weatherInfo.veleta,                       // Desde API
                    temp_max: weatherInfo.tempmax + '°C',                      // Desde API
                    temp_min: weatherInfo.tempmin + '°C',                      // Desde API
                    fwi: weatherInfo.fwi,                                      // Desde API
                    ultima_fecha: weatherInfo.fecha,                            // Desde API
                    visitas: 'En tiempo real' // Las visitas serían de otra API si existiera
                };

                console.log('✅ Estación cargada 100% desde API original:', station);

                // Ocultar loading y mostrar detalles
                document.getElementById('loading').style.display = 'none';
                document.getElementById('station-detail').style.display = 'block';

                // Renderizar detalles
                renderStationDetail(station);

                // Inicializar gráficos
                setTimeout(() => initializeCharts(chipid), 500);

            } catch (error) {
                console.error('Error loading station detail:', error);
                console.error('Error details:', error.message, error.stack);

                // Mostrar error más detallado
                const errorDiv = document.getElementById('error-message');
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = `
                    <div>❌ Error al cargar los detalles</div>
                    <div style="margin-top: 1rem; font-size: 0.9rem;">${error.message}</div>
                    <div style="margin-top: 0.5rem; font-size: 0.8rem;">Revisa la consola para más detalles</div>
                `;
            }
        }

        function renderStationDetail(station) {
            // Actualizar información básica
            document.getElementById('station-nickname').textContent = station.apodo || 'Estación sin nombre';
            document.getElementById('station-location').textContent = station.ubicacion || 'Ubicación desconocida';
            document.getElementById('station-visits').innerHTML = `<strong>${station.visitas || 0}</strong> visitas`;

            // Renderizar datos meteorológicos
            const weatherContent = document.getElementById('weather-content');
            weatherContent.innerHTML = '';

            // Datos meteorológicos actuales que vienen de la API
            const weatherFields = [
                { label: 'Temperatura Actual', key: 'temperatura', icon: '🌡️' },
                { label: 'Temperatura Máxima', key: 'temp_max', icon: '🔥' },
                { label: 'Temperatura Mínima', key: 'temp_min', icon: '❄️' },
                { label: 'Sensación Térmica', key: 'sensacion_termica', icon: '🤔' },
                { label: 'Humedad', key: 'humedad', icon: '💧' },
                { label: 'Presión', key: 'presion', icon: '📊' },
                { label: 'Viento', key: 'viento', icon: '💨' },
                { label: 'Dirección del Viento', key: 'direccion_viento', icon: '🧭' },
                { label: 'Índice de Peligro de Fuego', key: 'fwi', icon: '🔥' }
            ];

            if (station.ultima_fecha) {
                const fechaItem = document.createElement('div');
                fechaItem.className = 'weather-item';
                fechaItem.style.fontWeight = 'bold';
                fechaItem.style.textAlign = 'center';
                fechaItem.style.marginBottom = '10px';
                fechaItem.innerHTML = `
                    <span class="weather-value">Última actualización: ${new Date(station.ultima_fecha).toLocaleString('es-AR')}</span>
                `;
                weatherContent.appendChild(fechaItem);
            }

            weatherFields.forEach(field => {
                if (station[field.key]) {
                    const weatherItem = document.createElement('div');
                    weatherItem.className = 'weather-item';

                    let value = station[field.key];
                    if (field.key === 'fwi') {
                        value = getFireDangerDescription(parseFloat(value));
                    }

                    weatherItem.innerHTML = `
                        <span class="weather-label">${field.icon} ${field.label}:</span>
                        <span class="weather-value">${value}</span>
                    `;
                    weatherContent.appendChild(weatherItem);
                }
            });

            // Si no hay datos meteorológicos
            if (weatherContent.children.length === 0) {
                weatherItem = document.createElement('div');
                weatherItem.className = 'weather-item';
                weatherItem.innerHTML = `
                    <span class="weather-value" style="text-align: center; width: 100%;">
                        No hay datos meteorológicos disponibles en este momento
                    </span>
                `;
                weatherContent.appendChild(weatherItem);
            }
        }

        // Función para describir el peligro de fuego (similar a la del sitio original)
        function getFireDangerDescription(fwi) {
            if (fwi >= 50) return '🔴 Extremo';
            if (fwi >= 38) return '🟠 Muy alto';
            if (fwi >= 21.3) return '🟡 Alto';
            if (fwi >= 11.2) return '🟢 Moderado';
            if (fwi >= 5.2) return '🔵 Bajo';
            return '🔵 Muy bajo';
        }

        // ========== CHART.JS IMPLEMENTATION ==========

        let charts = {};
        let currentChart = 'temperature';
        let chartUpdateInterval;

        // Función para cambiar entre gráficos
        function showChart(type) {
            // Ocultar todos los gráficos
            document.querySelectorAll('.chart-section').forEach(section => {
                section.classList.remove('active');
            });

            // Mostrar el gráfico seleccionado
            document.getElementById(`chart-${type}`).classList.add('active');

            // Actualizar botones activos
            document.querySelectorAll('.chart-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Buscar el botón correcto según el tipo
            let btnSelector = '';
            switch(type) {
                case 'temperature': btnSelector = '.chart-btn.temp'; break;
                case 'humidity': btnSelector = '.chart-btn.humidity'; break;
                case 'wind': btnSelector = '.chart-btn.wind'; break;
                case 'pressure': btnSelector = '.chart-btn.pressure'; break;
                case 'fire': btnSelector = '.chart-btn.fire'; break;
            }

            const activeBtn = document.querySelector(btnSelector);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            currentChart = type;
        }

        // Función para obtener datos de la API
        async function getChartData(chipid) {
            try {
                const response = await fetch(`api/datos.php?chipid=${chipid}&cant=7`);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();

                // Verificar si hay un error en la respuesta
                if (data.error) {
                    console.error('Error de API:', data.error);
                    showChartError(data.error);
                    return null;
                }

                return data;
            } catch (error) {
                console.error('Error obteniendo datos para gráficos:', error);
                showChartError('No se pueden cargar los datos meteorológicos en este momento');
                return null;
            }
        }

        // Función para mostrar error en gráficos
        function showChartError(message) {
            // Ocultar todos los gráficos
            document.querySelectorAll('.chart-section').forEach(section => {
                section.classList.remove('active');
            });

            // Mostrar mensaje de error
            const errorHtml = `
                <div style="text-align: center; padding: 3rem; color: {{ COLOR_ACENTO_ALERTA }}; background: rgba(231, 76, 60, 0.1); border-radius: 10px; margin: 2rem;">
                    <div style="font-size: 2rem; margin-bottom: 1rem;">⚠️</div>
                    <div style="font-size: 1.2rem; font-weight: bold;">Error al cargar gráficos</div>
                    <div style="margin-top: 0.5rem;">${message}</div>
                    <div style="margin-top: 1rem; font-size: 0.9rem;">Por favor, intenta más tarde</div>
                </div>
            `;

            // Insertar mensaje en el primer contenedor de gráfico
            const firstContainer = document.querySelector('.chart-container');
            if (firstContainer) {
                firstContainer.innerHTML = errorHtml;
                firstContainer.parentElement.style.display = 'block';
            }

            // Actualizar timestamp
            document.getElementById('last-update').textContent =
                `Error: ${new Date().toLocaleTimeString('es-AR')}`;
        }

        // Función para crear o actualizar gráficos
        function updateCharts(data) {
            if (!data || data.length === 0) {
                showChartError('No hay datos disponibles para esta estación');
                return;
            }

            // Extraer datos para los gráficos
            const labels = data.map(item => {
                const fecha = new Date(item.fecha);
                return fecha.toLocaleTimeString('es-AR', { hour: '2-digit', minute: '2-digit' });
            });

            // Gráfico de Temperatura
            updateTemperatureChart(labels, data);

            // Gráfico de Humedad
            updateHumidityChart(labels, data);

            // Gráfico de Viento
            updateWindChart(labels, data);

            // Gráfico de Presión
            updatePressureChart(labels, data);

            // Gráfico de Riesgo de Incendio
            updateFireChart(labels, data);

            // Actualizar última actualización
            document.getElementById('last-update').textContent =
                `Última actualización: ${new Date().toLocaleTimeString('es-AR')}`;
        }

        // Gráfico de Temperatura
        function updateTemperatureChart(labels, data) {
            const ctx = document.getElementById('temperature-chart').getContext('2d');

            if (charts.temperature) {
                charts.temperature.destroy();
            }

            charts.temperature = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Temperatura',
                        data: data.map(item => parseFloat(item.temperatura)),
                        borderColor: '{{ COLOR_ACENTO_CLIMA }}',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: getChartOptions('Temperatura (°C)', '{{ COLOR_ACENTO_CLIMA }}')
            });
        }

        // Gráfico de Humedad
        function updateHumidityChart(labels, data) {
            const ctx = document.getElementById('humidity-chart').getContext('2d');

            if (charts.humidity) {
                charts.humidity.destroy();
            }

            charts.humidity = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Humedad',
                        data: data.map(item => parseFloat(item.humedad)),
                        borderColor: '#00bbf9',
                        backgroundColor: 'rgba(0, 187, 249, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: getChartOptions('Humedad (%)', '#00bbf9')
            });
        }

        // Gráfico de Viento
        function updateWindChart(labels, data) {
            const ctx = document.getElementById('wind-chart').getContext('2d');

            if (charts.wind) {
                charts.wind.destroy();
            }

            charts.wind = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Viento',
                        data: data.map(item => parseFloat(item.viento)),
                        borderColor: '#a8dadc',
                        backgroundColor: 'rgba(168, 218, 220, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: getChartOptions('Viento (Km/h)', '#a8dadc')
            });
        }

        // Gráfico de Presión
        function updatePressureChart(labels, data) {
            const ctx = document.getElementById('pressure-chart').getContext('2d');

            if (charts.pressure) {
                charts.pressure.destroy();
            }

            charts.pressure = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Presión',
                        data: data.map(item => parseFloat(item.presion)),
                        borderColor: '#6ee55d',
                        backgroundColor: 'rgba(110, 229, 93, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: getChartOptions('Presión (hPa)', '#6ee55d')
            });
        }

        // Gráfico de Riesgo de Incendio
        function updateFireChart(labels, data) {
            const ctx = document.getElementById('fire-chart').getContext('2d');

            if (charts.fire) {
                charts.fire.destroy();
            }

            charts.fire = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'FWI',
                        data: data.map(item => parseFloat(item.fwi)),
                        borderColor: '{{ COLOR_ACENTO_ALERTA }}',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: getChartOptions('Índice de Riesgo de Incendio (FWI)', '{{ COLOR_ACENTO_ALERTA }}')
            });
        }

        // Opciones comunes para todos los gráficos
        function getChartOptions(title, color) {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#333'
                        }
                    },
                    title: {
                        display: true,
                        text: title,
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        color: '#333'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#666'
                        }
                    },
                    y: {
                        grid: {
                            display: true,
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#666'
                        }
                    }
                },
                animation: {
                    duration: 750,
                    easing: 'easeInOutQuart'
                }
            };
        }

        // Auto-refresh cada 60 segundos
        function startAutoRefresh(chipid) {
            if (chartUpdateInterval) {
                clearInterval(chartUpdateInterval);
            }

            chartUpdateInterval = setInterval(async () => {
                console.log('Actualizando gráficos...');
                const data = await getChartData(chipid);
                updateCharts(data);
            }, 60000); // 60 segundos
        }

        // Inicializar gráficos cuando se carga la estación
        async function initializeCharts(chipid) {
            try {
                console.log('Inicializando gráficos para:', chipid);

                // Mostrar gráfico de temperatura por defecto
                showChart('temperature');

                const data = await getChartData(chipid);
                if (data && data.length > 0) {
                    updateCharts(data);
                    startAutoRefresh(chipid);
                } else {
                    showChartError('No hay datos disponibles para mostrar en los gráficos');
                }
            } catch (error) {
                console.error('Error al inicializar gráficos:', error);
                showChartError('Error al cargar los gráficos: ' + error.message);
            }
        }

            </script>
</body>
</html>