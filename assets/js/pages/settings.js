var validemail = false;
$(document).ready(function () {

    $('#saveSettings').submit(function (event) {
        event.preventDefault();

            if ($("#pass").val() != "") {
                if (!confirmpass()) {
                    message("error", "Las contraseñas deben ser iguales.");
                    return;
                }

                if (!checkpass()) {
                    message("error", "La contraseña debe tener al menos 6 caracteres y contener letras y números.");
                    return;
                }
            }

            if (checkExist('email', 'email', $("#actual_email").val())) {
                message("error", "El email es inválido o ya existe.");
                return;
            }

            var formData = new FormData(this);

            $.ajax({
                url: './src/controllers/actionsController.php?action=saveSettings',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res == 1 || res == 11) {
                        message("success", "Tu configuración se ha actualizado");
                        changeMode('view');
                        $('#saveSettings')[0].reset();
                        updateData();
                    } else {
                        message("error", "Algo salió mal");
                        console.log(res);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud. Código de estado: ' + xhr.status);
                }
            });
    });

    $("#deleteAccountForm").submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        
        $("#deleteAccountbtn").html('Borrando cuenta... <div class="spinner-border"></div>');
        $.ajax({
            url: './src/controllers/actionsController.php?action=deleteAccount',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    hideModal("deleteAccount");
                    message("success", "Se ha borrado tu cuenta ¡Nos vemos!. Actualizando..");
                    setTimeout(function () {
                        window.location.reload();
                    }, 2500);
                } else if (res == 10) {
                    message("error", "No se puede borrar tu cuenta porque tienes intercambios que administras.");
                } else if (res == 6) {
                    message("error", "El captcha es inválido. Actualiza la página e intentalo de nuevo.");
                } else {
                    message("error", "Algo salió mal");
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });

    });

});

function changeMode(mode) {
    if (mode == "edit") {
        $("#view-mode").hide();
        $("#edit-mode").show();
    } else if (mode == "view") {
        $('#saveSettings')[0].reset();
        $("#edit-mode").hide();
        $("#view-mode").show();
    }
}

function checkExist(inputv, element, actual) {
    var input = $('#'+inputv);
    var value = input.val();

    if (value && value != actual) {
            
        $.ajax({
            url: './src/controllers/actionsController.php?action=check' + element,
            type: 'POST',
            data: { input: value },
            success: function (res) {
                if (res == 1) {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    message("error", "Ese " + element + " ya existe.");
                    validemail = false;
                } else if (res == 0) {
                    validemail = true;
                } else if (res == 2) {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    message("error", "Ese " + element + " es inválido.");
                    validemail = false;
                } else {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    message("error", "Algo salió mal");
                    console.log(res);
                    validemail = false;
                }
            },
            error: function (xhr, status, error) {
                console.error('Request error. Status code: ' + xhr.status);
                validemail = false;
            }
        });
            
    } else if (!value && value != actual) {
        validemail = false;
    } else if (value && value == actual) {
        validemail = true;
    }
}


function updateData() {
    $("#loading").fadeIn();
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateProfile',
        type: 'POST',
        success: function (res) {
            var data = JSON.parse(res);
            user = data['user'];

            $("#view-email").html(user.email);
            $("#loading").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function checkpass() {
    var pass = $("#pass").val();

    if (pass == "") {
        message("error", "Ingresa una contraseña.");
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    
    if (pass.length < 6 || !/[a-zA-Z]/.test(pass) || !/\d/.test(pass)) {
        message("error", "La contraseña debe tener al menos 6 caracteres y contener letras y números.");
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    
    $("#pass").css('color', 'var(--pink)');
    $("#pass").css('border', '1px solid var(--pink)');
    return true;
}

function confirmpass() {
    if ($("#cpass").val() == "") {
        return false;
    }

    if ($("#pass").val() === $("#cpass").val()) {
        $("#cpass").css('color', 'var(--pink)');
        $("#cpass").css('border', '1px solid var(--pink)');
        return true;
    }
    $("#cpass").css('color', 'red');
    $("#cpass").css('border', '1px solid red');
    message("error", "Las contraseñas deben ser iguales.");
    return false;
}


