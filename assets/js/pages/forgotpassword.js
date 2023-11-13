$(document).ready(function () {

    $("#forgotpassword").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=forgotPassword',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1 || res == "1null") {
                    $("#forgotpassword")[0].reset();
                    message("success", "El código de recuperación de contraseña se envió a tu email");
                }else if (res == 6) {
                    message("error", "El captcha es inválido");
                } else if (res == 9) {
                    message("error", "No hay ningún registro con esos datos");
                } else {
                    message("error", "Algo salió mal");
                    console.log(res);
                }
            },
            error: function (xhr, status, error) {
                message("error", "Error: "+error);
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

});