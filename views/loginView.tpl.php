@component(head)

<div class="container">
    <a href="?slug=landing" class="link-back">← Volver al Inicio</a>

    <div class="form-container">
        <div class="form-card">
            <form method="POST" action="?slug=login" class="login-form">
                {{ ERROR_MESSAGE }}

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="tu@email.com">
                </div>

                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required placeholder="•••••••••">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-form btn-primary">Iniciar Sesión</button>
                </div>
            </form>

            <div class="form-links">
                <a href="?slug=register">Registrarse</a>
                <a href="?slug=recuperar">¿Olvidaste tu contraseña?</a>
            </div>
        </div>
    </div>
</div>

@component(footer)