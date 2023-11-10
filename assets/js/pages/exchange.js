$(document).ready(function () {

    $("#kickUserExchange").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=kickUserExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha eliminado al usuario del intercambio");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
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

    $("#comment").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=newCommentPost',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    $("#comment").val("");
                    updateComments();
                }else if (res == "5") {
                    message("warning", "you need to log in or register");
                } else {
                    message("error", "There was an error");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

    $("#deleteComment").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=deleteCommentPost',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    updateComments();
                }else if (res == "5") {
                    message("warning", "you need to log in or register");
                } else {
                    message("error", "There was an error");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

    $("#giveAdminForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=giveAdmin',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha cambiado el admin de este intercambio");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2500);
                } else {
                    message("error", "Algo salió mal");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

    $("#editExchangeForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=editExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha editado el intercambio");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2500);
                } else {
                    message("error", "Algo salió mal");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

});

function kickUserExchange(id_exchange, id_user, name_user) {
    $("#kickUserExchange_id_user").val(id_user);
    $("#kickUserExchange_id_exchange").val(id_exchange);
    $("#kickUserExchange_text").text(name_user);
}

function updateComments() {
    $("#comments-post").empty();
    $("#comments-post").html('<div class="spinner-border"></div>');
    const id_exchange = $("#id_exchange").val();
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateCommentPost',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            if (res == 2) {
                message("error", "There was an error");
                console.log(res);
            } else {
                res = JSON.parse(res);
                $("#comments-post").html(res);
                changeToRelativeTime('relativedate');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function deleteComment(id_user, id_comm) {
    $("#delete-iduser").val(id_user);
    $("#delete-idcomm").val(id_comm);
}

function giveAdmin(id_user, username) {
    $("#giveAdmin_id_user").val(id_user);
    $("#giveAdmin_text").text(username);
}