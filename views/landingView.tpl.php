@component(head)

<style>
    /* Header del inicio */
    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title {
        flex: 1;
    }

    .header-nav {
        display: flex;
        gap: 1rem;
    }

    .nav-btn {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        text-decoration: none;
        border-radius: 20px;
        font-weight: bold;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        color: var(--color-blanco);
    }

    .login-btn { background-color: var(--color-acento-clima); }
    .login-btn:hover { background-color: #2980b9; }

    .register-btn { background-color: var(--color-acento-secundario); }
    .register-btn:hover { background-color: #229954; }

    .nav-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>

<div class="header">
    <div class="header-content">
        <div class="header-title">
            <h1>{{ APP_NAME }}</h1>
            <p>{{ APP_DESCRIPTION }}</p>
        </div>
        <div class="header-nav">
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="?slug=login" class="nav-btn login-btn">Iniciar Sesión</a>
                <a href="?slug=register" class="nav-btn register-btn">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="description">
            <h2>Monitoreo Meteorológico en Tiempo Real</h2>
            <p>
                Accede a datos actualizados de múltiples estaciones meteorológicas distribuidas en diferentes ubicaciones.
                Visualiza información clave como temperatura, humedad, presión atmosférica y condiciones climáticas en tiempo real.
                Nuestra plataforma te permite consultar el historial y recibir alertas sobre cambios climáticos importantes.
            </p>
        </div>

        <a href="?slug=panel" class="cta-button">Ver Panel de Estaciones</a>

        <div class="features">
            <div class="feature">
                <h3>🌡️ Datos en Vivo</h3>
                <p>Información meteorológica actualizada cada minuto</p>
            </div>
            <div class="feature">
                <h3>📍 Múltiples Ubicaciones</h3>
                <p>Estaciones distribuidas estratégicamente</p>
            </div>
            <div class="feature">
                <h3>📊 Historial Completo</h3>
                <p>Acceso a datos históricos y tendencias</p>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .description {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 3rem;
    }

    .description h2 {
        color: {{ COLOR_ACENTO_CLIMA }};
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .description p {
        color: {{ COLOR_TEXTO_SECUNDARIO }};
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .cta-button {
        display: inline-block;
        background-color: {{ COLOR_ACENTO_CLIMA }};
        color: {{ COLOR_BOTON_PRINCIPAL_TEXTO }};
        padding: 1rem 2.5rem;
        text-decoration: none;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin: 2rem 0;
    }

    .cta-button {
        display: inline-block;
        padding: 1rem 2rem;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        margin: 0.5rem;
    }

    .login-btn {
        background-color: {{ COLOR_ACENTO_CLIMA }};
        color: {{ COLOR_BOTON_PRINCIPAL_TEXTO }};
    }

    .register-btn {
        background-color: {{ COLOR_ACENTO_SECUNDARIO }};
        color: {{ COLOR_BOTON_PRINCIPAL_TEXTO }};
    }

    .panel-btn {
        background-color: {{ COLOR_ACENTO_ALERTA }};
        color: {{ COLOR_BOTON_PRINCIPAL_TEXTO }};
    }

    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .login-btn:hover {
        background-color: #2980b9;
    }

    .register-btn:hover {
        background-color: #229954;
    }

    .panel-btn:hover {
        background-color: #c0392b;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }

    .feature {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .feature:hover {
        transform: translateY(-5px);
    }

    .feature h3 {
        color: {{ COLOR_ACENTO_CLIMA }};
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }

    .feature p {
        color: {{ COLOR_TEXTO_SECUNDARIO }};
        font-size: 1rem;
    }
</style>

@component(footer)