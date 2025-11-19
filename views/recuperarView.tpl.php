

@component(head)

<div class="container">
    <div class="form-container">
        <div class="form-card recovery-form">
            {{ ERROR_MESSAGE }}
            {{ SUCCESS_MESSAGE }}

            <form method="POST" action="?slug=recuperar" class="recovery-form">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="tu@email.com">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-form btn-danger">Enviar Correo de Recuperación</button>
                </div>
            </form>

            <div class="form-back-link">
                <a href="?slug=login">← Volver al Login</a>
            </div>
        </div>
    </div>
</div>