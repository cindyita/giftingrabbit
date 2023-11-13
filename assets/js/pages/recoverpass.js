$(document).ready(function () {


    $('#recoverPass').submit(function (event) {

        event.preventDefault();

        if (!confirmpass()) {
            $("#error-login span").html("Las contraseñas deben ser iguales.");
            $("#error-login").fadeIn();
            return;
        }

        if (!checkpass()) {
            $("#error-login span").html("La contraseña debe tener al menos 6 caracteres y contener letras y números.");
            $("#error-login").fadeIn();
            return;
        }

        $('#error-login').fadeOut();

        var formData = $(this).serialize();

        $.ajax({
            url: './src/controllers/actionsController.php?action=recoverPass',
            type: 'POST',
            data: formData,
            success: function (res) {
                if (res == 1 || res == "1null") {
                    $('#success-login').fadeIn();
                    $("#recoverPass")[0].reset();
                } else if (res == 6) {
                    $('#error-login span').html("El captcha no es válido. Actualiza la página y vuelve a intentarlo.");
                    $('#error-login').fadeIn();
                } else {
                    $('#error-login span').html("Hubo un error");
                    $('#error-login').fadeIn();
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

});

function checkpass() {
    var pass = $("#pass").val();

    if (pass == "") {
        $("#error-login span").html("Ingresa una contraseña");
        $("#error-login").fadeIn();
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    
    if (pass.length < 6 || !/[a-zA-Z]/.test(pass) || !/\d/.test(pass)) {
        $("#error-login span").html("La contraseña debe tener al menos 6 caracteres y contener letras y números.");
        $("#error-login").fadeIn();
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    
    $("#pass").css('color', 'var(--pink)');
    $("#pass").css('border', '1px solid var(--pink)');
    $("#error-login").fadeOut();
    return true;
}

function confirmpass() {
    if ($("#cpass").val() == "") {
        return false;
    }
    if ($("#pass").val() === $("#cpass").val()) {
        $("#cpass").css('color', 'var(--pink)');
        $("#cpass").css('border', '1px solid var(--pink)');
        $("#error-login").fadeOut();
        return true;
    }
    $("#cpass").css('color', 'red');
    $("#cpass").css('border', '1px solid red');
    $("#error-login span").html("Las contraseñas deben ser las mismas.");
    $("#error-login").fadeIn();
    return false;
}