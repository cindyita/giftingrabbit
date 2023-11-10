$(document).ready(function () {

    $("#contact").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=sendContactForm',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    $("#contact")[0].reset();
                    message("success", "Tu mensaje fue enviado");
                }else if (res == "6") {
                    message("danger", "El captcha es inválido");
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