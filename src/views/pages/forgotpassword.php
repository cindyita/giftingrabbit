<div class="main-login">

    <div class="login pink-box">
        <div class="logo">
            <a href="home"><img src="./assets/img/system/logo.png" alt="logo"></a>
        </div>
        <div>
            <h4>Olvidé mi contraseña</h4>
            <form method="post" id="forgotpassword">
                <div class="mb-3">
                    <label for="usernamemail" class="form-label">Nombre de usuario o email</label>
                    <input type="text" class="form-control" id="usernamemail" placeholder="Ingresa tu nombre de usuario o tu email" name="usernamemail">
                </div>
                <div class="d-flex justify-content-center mb-3"><div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div></div>
                <button type="submit" class="button-primary">Enviar código de recuperación</button>
            </form>
        </div>
    </div>

</div>