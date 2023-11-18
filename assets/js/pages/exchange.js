$(document).ready(function () {

    // getCollapse();

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
                    message("success", "Se ha eliminado al usuario del intercambio. Actualizando..");
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
                    $("#comment_exchange").val("");
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
                    message("success", "Se ha cambiado el admin de este intercambio. Actualizando..");
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
        if ($("#min_price").val() > $("#max_price").val()) {
            message("error", "El precio mínimo no puede ser mayor al precio máximo");
            return;
        }
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=editExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    hideModal("editExchange");
                    message("success", "Se ha editado el intercambio. Actualizando..");
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

    $("#wantGiftForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=newWantGift',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha agregado tu respuesta");
                    $("#wantGift_comment").val("");
                    updateWantGift();
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

    $("#deleteWantGift").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=deleteWantGift',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha borrado tu respuesta");
                    updateWantGift();
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

    $("#newContactForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=newContact',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha agregado el contacto. Actualizando..");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
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

function updateWantGift() {
    $("#updateWantGift").empty();
    $("#updateWantGift").html('<div class="spinner-border"></div>');
    const id_exchange = $("#id_exchange").val();
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateWantGift',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            if (res == 2) {
                message("error", "There was an error");
                console.log(res);
            } else {
                res = JSON.parse(res);
                $("#updateWantGift").html(res);
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

function deleteWantGift(id_wantgift) {
    $("#deleteWantGift-idcomm").val(id_wantgift);
}

function deleteContact(id,name) {
    $("#deleteContact-text").text(name);
    $("#deleteContact-id").val(id);
}

function viewContact(info) {
    $("#viewContact-name").text(info['name']);
    $("#viewContact-email").text(info['email']);
    $("#viewContact-wantgift").text(info['wantgift']);
    $("#viewContact-note").text(info['note']);
    const id_exchange = $("#id_exchange").val();

    $("#viewContact-result").html('<div class="spinner-border"></div>');

    $.ajax({
        url: './src/controllers/actionsController.php?action=resultContact',
        type: 'POST',
        data: {id: info['id'],id_exchange:id_exchange},
        success: function (res) {
            res = JSON.parse(res)[0];
            res['type_result'] = res['type_result'] == 'USER' ? 'Usuario' : "Contacto";
            res['result_comment'] = res['result_comment'] ? res['result_comment'] : "";
            res['result_note'] = res['result_note'] ? res['result_note'] : "";
            var html = '<span>Tipo: '+res['type_result']+'</span><br><span>Nombre: '+res['result_name']+'</span><br><span>Respuesta: '+res['result_comment']+'</span><br><span>Notas: '+res['result_note']+'</span>';
            $("#viewContact-result").html(html);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });

}

function makeRaffle(id_exchange) {
    $("#raffle-loading").show();
    $.ajax({
        url: './src/controllers/actionsController.php?action=makeRaffle',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            console.log(res);
            if (res == 1) {
                message("success", "¡Se ha realizado el sorteo! Actualizando..");
                showConfetti();
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            } else if (res == 5) {
                message("error", "Inicia sesión para realizar esta acción");
            } else if (res == 6) {
                message("error", "No tienes permisos para realizar esta acción");
            } else if (res == 7) {
                message("error", "¡Los participantes no pueden ser menos de 3!");
            } else {
                message("error", "Algo salió mal");
                console.log(res);
            }
            $("#raffle-loading").fadeOut();
            hideModal("makeRaffle");
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function viewResultsRaffle(id_exchange) {
    $("#viewResultsRaffle-content").empty();
    $("#viewResultsRaffle-content").html('<div class="spinner-border"></div>');
    $.ajax({
        url: './src/controllers/actionsController.php?action=viewResultsRaffle',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            res = JSON.parse(res);
            var html = "";
            res.forEach(element => {
                html += '<p>' + element['user_name'] + ' ['+element['type_user']+']' + ' => '+element['result_name']+' ['+element['type_result']+']' +'</p>';
            });
            $("#viewResultsRaffle-content").html(html);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function sendResultsByEmail(id_exchange) {
    $("#sendEmail-loading").show();
    $.ajax({
        url: './src/controllers/actionsController.php?action=sendResultsByEmail',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            console.log(res);
            if (res == 1) {
                message("success", "¡Se han enviado los resultados por email!");
                // setTimeout(function() {
                //     window.location.reload();
                // }, 2000);
            } else if (res == 5) {
                message("error", "Inicia sesión para realizar esta acción");
            } else if (res == 6) {
                message("error", "No tienes permisos para realizar esta acción");
            } else {
                message("error", "Algo salió mal");
                console.log(res);
            }
            $("#sendEmail-loading").fadeOut();
            hideModal("sendResultsByEmail");
            $("#send_email_success").text("Los emails fueron enviados");
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function showConfetti() {
    confetti({
        particleCount: 150,
        spread: 60,
        zIndex: 2000,
        colors: ["#FF8211", "#64F8A9"]
    });
}

function entranceLock(id_exchange) {
    $.ajax({
        url: './src/controllers/actionsController.php?action=entranceLock',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            console.log(res);
            if (res == 1) {
                hideModal('entranceLock');
                message("success", "Se han bloqueado las entradas al intercambio. Actualizando..");
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            } else if (res == 5) {
                message("error", "Inicia sesión para realizar esta acción");
            } else if (res == 6) {
                message("error", "No tienes permisos para realizar esta acción");
            } else {
                message("error", "Algo salió mal");
                console.log(res);
            }
            $("#sendEmail-loading").fadeOut();
            hideModal("sendResultsByEmail");
            $("#send_email_success").text("Los emails fueron enviados");
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function entranceUnlock(id_exchange) {
    $.ajax({
        url: './src/controllers/actionsController.php?action=entranceUnlock',
        type: 'POST',
        data: {id_exchange: id_exchange},
        success: function (res) {
            console.log(res);
            if (res == 1) {
                hideModal('entranceUnlock');
                message("success", "Se han desbloqueado las entradas al intercambio. Actualizando..");
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            } else if (res == 5) {
                message("error", "Inicia sesión para realizar esta acción");
            } else if (res == 6) {
                message("error", "No tienes permisos para realizar esta acción");
            } else {
                message("error", "Algo salió mal");
                console.log(res);
            }
            $("#sendEmail-loading").fadeOut();
            hideModal("sendResultsByEmail");
            $("#send_email_success").text("Los emails fueron enviados");
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}