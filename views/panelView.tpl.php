@component(head)
@component(header)
<div class="container">
    <a href="?slug=landing" class="link-back">← Volver al Inicio</a>

    <div id="loading" class="loading" style="display: none;">
        <div>🌡️ Cargando estaciones...</div>
    </div>

    <div id="error-message" class="error-message" style="display: none;">
        <div>❌ No se pudieron cargar las estaciones. Por favor, intenta nuevamente.</div>
    </div>

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

    // Animación de entrada para las tarjetas
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.station-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Mostrar loading si no hay estaciones
        const stationsContainer = document.getElementById('stations-container');
        const loadingDiv = document.getElementById('loading');

        if (!stationsContainer.innerHTML.trim() || stationsContainer.children.length === 0) {
            loadingDiv.style.display = 'block';
        } else {
            loadingDiv.style.display = 'none';
        }
    });

    // Función para recargar estaciones
    async function refreshStations() {
        const loadingDiv = document.getElementById('loading');
        const errorDiv = document.getElementById('error-message');
        const container = document.getElementById('stations-container');

        try {
            loadingDiv.style.display = 'block';
            errorDiv.style.display = 'none';

            // Aquí podrías agregar una llamada AJAX para recargar las estaciones
            // Por ahora, recargamos la página
            setTimeout(() => {
                window.location.reload();
            }, 1000);

        } catch (error) {
            loadingDiv.style.display = 'none';
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = `
                <div>❌ Error al cargar estaciones</div>
                <div style="margin-top: 1rem; font-size: 0.9rem;">${error.message}</div>
            `;
        }
    }
</script>