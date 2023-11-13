<div class="main-login">

    <div class="login pink-box">
        <div class="logo">
            <a href="home"><img src="./assets/img/system/logo.webp" alt="logo"></a>
        </div>
        <div>
            <h4>Recuperación de contraseña</h4>
            <form method="post" id="recoverPass">
                <div class="alert alert-danger" id="error-login">
                    <strong>Error:</strong> <span>Error al iniciar sesión</span>
                </div>
                <div class="alert alert-success" id="success-login">
                    <strong>¡Éxito!</strong> <span>Se ha actualizado exitosamente. Ahora puedes <a href="login">iniciar sesión</a></span>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" id="pass" placeholder="Ingresa la nueva contraseña" name="pass" onblur="checkpass()" required>
                </div>
                <div class="mb-3">
                    <label for="cpass" class="form-label">Confirma tu contraseña</label>
                    <input type="password" class="form-control" id="cpass" placeholder="Confirma la nueva contraseña" name="cpass" onblur="confirmpass()" required>
                </div>
                <div class="d-flex justify-content-center mb-3"><div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div></div>
                <input type="hidden" name="id_user" value="<?php echo $tokens[0]['id_user']; ?>" required>
                <input type="hidden" name="token" value="<?php echo $token; ?>" required>
                <button type="submit" class="button-primary">Enviar</button>
            </form>
        </div>
    </div>

</div>