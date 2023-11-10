<div class="main">

    <div class="white-box">
        <div class="d-flex justify-content-center">
            <h5 class="page-title">Contáctanos</h5>
        </div>
        <div class="d-flex justify-content-center">

            <form method="post" id="contact" class="contact-form">
                <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="name" placeholder="Ingresa tu nombre" name="name">
                </div>
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingresa tu email" name="email">
                </div>
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Asunto:</label>
                    <select class="form-select" name="subject">
                        <option>Sugerencia</option>
                        <option>Reporte de error/bug</option>
                        <option>Problema</option>
                        <option>Contacto</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Comentario:</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" placeholder="ingresa tus sugerencias o informe de error"></textarea>
                </div>
                <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div>
                <div><button type="submit" class="button-primary mt-2">Enviar</button></div>
            </form>

        </div>
    </div>
</div>
