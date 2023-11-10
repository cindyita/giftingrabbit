$(document).ready(function () {

    $('#saveProfile').submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        checkExist('username', 'username', $("#actual_username").val())
        .then(function () {

            $.ajax({
                url: './src/controllers/actionsController.php?action=saveprofile',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res == 1 || res == 11) {
                        message("success", "Tu perfil se ha actualizado");
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
        }).catch(function () {
            message("error", "Error de nombre de usuario");
        });
    });

    dateFormatting2("view-birthday");

});

function changeMode(mode) {
    if (mode == "edit") {
        $("#view-mode").hide();
        $("#edit-mode").show();
    } else if (mode == "view") {
        $("#edit-mode").hide();
        $("#view-mode").show();
    }
}

function checkExist(inputv, element, actual) {
    var input = $('#'+inputv);
    var value = input.val();

    return new Promise(function(resolve, reject) {
        if (value && value != actual) {
            
                $.ajax({
                    url: './src/controllers/actionsController.php?action=check'+element,
                    type: 'POST',
                    data: {input: value},
                    success: function (res) {
                        console.log(res);
                        if (res == 1) {
                            $(input).css('color', 'red');
                            $(input).css('border', '1px solid red');
                            message("error", "Ese nombre de usuario ya existe.");
                            reject();
                        } else if (res == 0) {
                            resolve();
                        } else if (res == 2) {
                            $(input).css('color', 'red');
                            $(input).css('border', '1px solid red');
                            message("error", "Ese nombre de usuario es inválido.");
                            reject();
                        } else {
                            $(input).css('color', 'red');
                            $(input).css('border', '1px solid red');
                            message("error", "Algo salió mal");
                            console.log(res);
                            reject();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Request error. Status code: ' + xhr.status);
                        reject();
                    }
                });
            
        } else if (!value && value != actual) {
            reject();
        } else if (value && value == actual) {
            resolve();
        }
    });
}


function updateData() {
    $("#loading").fadeIn();
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateProfile',
        type: 'POST',
        success: function (res) {
            var data = JSON.parse(res);
            user = data['user'];

            $("#view-username").html(user.username);
            $("#view-birthday").html(user.birthday);
            $("#view-likes").html(user.likes);
            $("#view-dislikes").html(user.dislikes);

            $("#view-biography").html(user.biography);

            if (user.img_profile) {
                $(".img-profile img").attr("src", "./assets/img/user/img-profile/" + user.img_profile+'?upd=<?php echo time(); ?>');
                $("#img-preview").attr("src", "./assets/img/user/img-profile/" + user.img_profile+'?upd=<?php echo time(); ?>');
            } else {
                $(".img-profile img").attr("src", "./assets/img/system/defaultimgsq.jpg");
                $("#img-preview").attr("src", "./assets/img/system/defaultimgsq.jpg");
            }

            $("#username").val(user.username);
            $("#actual_username").val(user.username);
            $("#birthday").val(user.birthday);

            dateFormatting2("view-birthday");

            $("#loading").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}
