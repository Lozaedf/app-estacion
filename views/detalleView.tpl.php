@component(head)

@component(header)

<div class="container">
    <a href="?slug=panel" class="link-back">← Volver al Panel</a>

    <div id="loading" class="loading">
        <div>🌡️ Cargando detalles de la estación...</div>
    </div>

    <div id="error-message" class="error-message" style="display: none;">
        <div>❌ No se pudieron cargar los detalles de la estación. Por favor, intenta nuevamente.</div>
    </div>

    <div id="station-detail" style="display: none;">
        <div class="card">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        const weatherInfo = weatherData[0];
        const station = {
            chipid: chipid,
            apodo: weatherInfo.estacion || `Estación ${chipid}`,
            ubicacion: weatherInfo.ubicacion || 'Ubicación desconocida',
            temperatura: weatherInfo.temperatura + '°C',
            sensacion_termica: weatherInfo.sensacion + '°C',
            humedad: weatherInfo.humedad + '%',
            presion: weatherInfo.presion + ' hPa',
            viento: weatherInfo.viento + ' Km/h',
            direccion_viento: weatherInfo.veleta,
            temp_max: weatherInfo.tempmax + '°C',
            temp_min: weatherInfo.tempmin + '°C',
            fwi: weatherInfo.fwi,
            ultima_fecha: weatherInfo.fecha,
            visitas: 'En tiempo real'
        };

        // Ocultar loading y mostrar detalles
        document.getElementById('loading').style.display = 'none';
        document.getElementById('station-detail').style.display = 'block';

        // Renderizar detalles
        renderStationDetail(station);

        // Inicializar gráficos
        setTimeout(() => initializeCharts(chipid), 500);

    } catch (error) {
        console.error('Error loading station detail:', error);

        const errorDiv = document.getElementById('error-message');
        errorDiv.style.display = 'block';
        errorDiv.innerHTML = `
            <div>❌ Error al cargar los detalles</div>
            <div style="margin-top: 1rem; font-size: 0.9rem;">${error.message}</div>
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
}

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

function showChart(type) {
    document.querySelectorAll('.chart-section').forEach(section => {
        section.classList.remove('active');
    });

    document.getElementById(`chart-${type}`).classList.add('active');

    document.querySelectorAll('.chart-btn').forEach(btn => {
        btn.classList.remove('active');
    });

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

async function getChartData(chipid) {
    try {
        const response = await fetch(`api/datos.php?chipid=${chipid}&cant=7`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error obteniendo datos para gráficos:', error);
        return null;
    }
}

function updateCharts(data) {
    if (!data || data.length === 0) return;

    const labels = data.map(item => {
        const fecha = new Date(item.fecha);
        return fecha.toLocaleTimeString('es-AR', { hour: '2-digit', minute: '2-digit' });
    });

    updateTemperatureChart(labels, data);
    updateHumidityChart(labels, data);
    updateWindChart(labels, data);
    updatePressureChart(labels, data);
    updateFireChart(labels, data);

    document.getElementById('last-update').textContent =
        `Última actualización: ${new Date().toLocaleTimeString('es-AR')}`;
}

function updateTemperatureChart(labels, data) {
    const ctx = document.getElementById('temperature-chart').getContext('2d');
    if (charts.temperature) charts.temperature.destroy();

    charts.temperature = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperatura',
                data: data.map(item => parseFloat(item.temperatura)),
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: getChartOptions('Temperatura (°C)', '#3498db')
    });
}

function updateHumidityChart(labels, data) {
    const ctx = document.getElementById('humidity-chart').getContext('2d');
    if (charts.humidity) charts.humidity.destroy();

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

function updateWindChart(labels, data) {
    const ctx = document.getElementById('wind-chart').getContext('2d');
    if (charts.wind) charts.wind.destroy();

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

function updatePressureChart(labels, data) {
    const ctx = document.getElementById('pressure-chart').getContext('2d');
    if (charts.pressure) charts.pressure.destroy();

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

function updateFireChart(labels, data) {
    const ctx = document.getElementById('fire-chart').getContext('2d');
    if (charts.fire) charts.fire.destroy();

    charts.fire = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'FWI',
                data: data.map(item => parseFloat(item.fwi)),
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: getChartOptions('Índice de Riesgo de Incendio (FWI)', '#e74c3c')
    });
}

function getChartOptions(title, color) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            title: {
                display: true,
                text: title
            }
        },
        scales: {
            x: {
                grid: { display: true },
                ticks: { font: { size: 12 } }
            },
            y: {
                grid: { display: true },
                ticks: { font: { size: 12 } }
            }
        },
        animation: {
            duration: 750,
            easing: 'easeInOutQuart'
        }
    };
}

async function initializeCharts(chipid) {
    try {
        showChart('temperature');
        const data = await getChartData(chipid);
        if (data && data.length > 0) {
            updateCharts(data);
            startAutoRefresh(chipid);
        }
    } catch (error) {
        console.error('Error al inicializar gráficos:', error);
    }
}

function startAutoRefresh(chipid) {
    if (chartUpdateInterval) {
        clearInterval(chartUpdateInterval);
    }

    chartUpdateInterval = setInterval(async () => {
        console.log('Actualizando gráficos...');
        const data = await getChartData(chipid);
        updateCharts(data);
    }, 60000);
}
</script>