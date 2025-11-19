

@component(head)

<div class="container">
    <div class="form-container">
        <div class="form-card reset-form">
            {{ ERROR_MESSAGE }}
            {{ SUCCESS_MESSAGE }}

            <form method="POST" action="?slug=reset&token_action={{ RESET_TOKEN }}" class="reset-form">
                <div class="form-group">
                    <label for="contraseña">Nueva Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" minlength="8" required placeholder="Mínimo 8 caracteres">
                </div>

                <div class="form-group">
                    <label for="confirmar_contraseña">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" minlength="8" required placeholder="Repite tu contraseña">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-form btn-secondary">Restablecer Contraseña</button>
                </div>
            </form>

            <div class="form-links">
                <a href="?slug=login">← Volver al Login</a>
            </div>
        </div>
    </div>
</div>