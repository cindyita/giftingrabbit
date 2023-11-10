$(document).ready(function () {

    /*--remember login--*/
    if (localStorage.getItem('rememberedUsername')) {
        $('#username').val(localStorage.getItem('rememberedUsername'));
        $('#remember').prop('checked', true);
    }
    /*------------------*/

    $('#login').submit(function (event) {

        $('#error-login').hide();

        /*----Remember me---*/
        if ($('#remember').is(':checked')) {

            localStorage.setItem('rememberedUsername', $('#username').val());
        } else {
            localStorage.removeItem('rememberedUsername');
        }
        /*----------------------------*/

        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: './src/controllers/actionsController.php?action=login',
            type: 'POST',
            data: formData,
            success: function (res) {
                if (res == 1) {
                    window.location.href = 'home';
                } else if (res == 2) {
                    $('#error-login span').html("El captcha no es válido. Actualiza la página y vuelve a intentarlo.");
                    $('#error-login').fadeIn();
                } else if (res == 0) {
                    $('#error-login span').html("El nombre de usuario y/o contraseña son incorrectos");
                    $('#error-login').fadeIn();
                } else {
                    $('#error-login span').html("Error al iniciar sesión");
                    $('#error-login').fadeIn();
                    console.log(res);
                }
            },
            error: function (xhr, status, error) {
                $("#error-login span").html("Error: "+error);
                $("#error-login").fadeIn();
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

});