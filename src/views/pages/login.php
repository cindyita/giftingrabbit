<div class="main-login">

    <div class="login pink-box">
        <div class="logo">
            <a href="home"><img src="./assets/img/system/logo.png" alt="logo"></a>
        </div>
        <div>
            <h4>Login</h4>
            <form method="post" id="login">
                <div class="alert alert-danger" id="error-login">
                    <strong>Alerta:</strong> <span>Error al iniciar sesión</span>
                </div>
                <div class="mb-3 mt-3">
                    <label for="username" class="form-label">Nombre de usuario o email</label>
                    <input type="text" class="form-control" id="username" placeholder="Ingresa tu nombre de usuario o tu email" name="username">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass" placeholder="Ingresa tu contraseña" name="pass">
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember"> Recuerdame
                    </label>
                </div>
                <div class="py-2 pb-4 d-flex flex-column">
                    <!-- <a href=""><span>I forgot the password</span></a> -->
                    <a href="signup"><strong>¿Aún no tienes una cuenta? Regístrate.</strong></a>
                    <a href="forgotpassword"><strong>¿Olvidaste tu contraseña? Click aquí.</strong></a>
                </div>
                <div class="d-flex justify-content-center"><div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div></div>
                <button type="submit" class="mt-2 button-primary">Login</button>
            </form>
        </div>
    </div>

</div>