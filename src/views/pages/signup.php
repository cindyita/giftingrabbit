<div class="main-login">

    <div class="login pink-box">
        <div class="logo">
            <a href="home"><img src="./assets/img/system/logo.webp" alt="logo"></a>
        </div>
        <div>
            <h4>Registro</h4>
            <form method="post" id="signup">
                <div class="alert alert-danger" id="error-login">
                    <strong>Error:</strong> <span>Error al registrarse</span>
                </div>
                <div class="alert alert-success" id="success-login">
                    <strong>¡Éxito!</strong> <span>Se ha registrado exitosamente. Ahora puedes iniciar sesión</span>
                </div>
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Ingresa tu correo electrónico" name="email" onblur="checkExist('email','email')" required>
                </div>
                <div class="mb-3 mt-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username" placeholder="Ingresa un nombre de usuario (único)" name="username" onblur="checkExist('username','username')" required>
                </div>
                <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Tu nombre</label>
                    <input type="text" class="form-control" id="name" placeholder="Ingresa tu nombre" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass" placeholder="Ingresa una contraseña" name="pass" onblur="checkpass()" required>
                </div>
                <div class="mb-3">
                    <label for="cpwd" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="cpass" placeholder="Confirma la contraseña" name="cpass" onblur="confirmpass()" required>
                </div>
                <div class="py-2 pb-4 d-flex flex-column">
                    <a href="login"><strong>¿Ya tienes una cuenta? Inicia sesión.</strong></a>
                </div>
                <div class="d-flex justify-content-center"><div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div></div>
                <button type="submit" class="button-primary mt-2">Registrarse</button>
            </form>
        </div>
    </div>

</div>