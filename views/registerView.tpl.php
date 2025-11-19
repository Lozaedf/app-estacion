

@component(head)

<div class="container">
    <a href="?slug=landing" class="link-back">← Volver al Inicio</a>

    <div class="form-container">
        <div class="form-card form-card-md">
            <form method="POST" action="?slug=register" class="register-form">
                {{ ERROR_MESSAGE }}
                {{ SUCCESS_MESSAGE }}

                <div class="form-group">
                    <label for="nombres">Nombre completo:</label>
                    <input type="text" id="nombres" name="nombres" required placeholder="Juan Pérez">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="tu@email.com">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" id="contraseña" name="contraseña" minlength="8" required placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label for="confirmar_contraseña">Repetir Contraseña:</label>
                        <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" minlength="8" required placeholder="••••••••">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-form btn-secondary">Registrarse</button>
                </div>
            </form>

            <div class="form-links">
                <a href="?slug=login">¿Ya tienes cuenta? Iniciar Sesión</a>
            </div>
        </div>
    </div>
</div>