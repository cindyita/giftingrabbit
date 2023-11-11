$(document).ready(function () {

    $("#newExchangeForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=createExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Se ha creado el intercambio :)");
                    updateExchanges();
                } else {
                    message("danger", "Error creando el intercambio :(");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

    $("#joinExchangeForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=joinExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "te has unido al intercambio :)");
                    updateExchanges();
                } else if (res == 2) {
                    message("error", "El código es inválido");
                } else if (res == 3) {
                    message("error", "No hay ningún intercambio con ese código");
                } else {
                    message("danger", "Error uniendote al intercambio :(");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

    $("#exitExchangeForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=exitExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "te has salido del intercambio");
                    updateExchanges();
                } else {
                    message("danger", "Error saliendote del intercambio");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

    $("#deleteExchangeForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=deleteExchange',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    message("success", "Has eliminado el intercambio");
                    updateExchanges();
                } else {
                    message("danger", "Error eliminando del intercambio");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });
    
});


function updateExchanges() {
    $("#feedExchanges").empty();
    $("#feedExchanges").html('<div class="spinner-border"></div>');
    $.ajax({
            url: './src/controllers/actionsController.php?action=updateFeedExchanges',
            type: 'POST',
            data: {},
        success: function (res) {
                $("#feedExchanges").html(JSON.parse(res));
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
}

function exitExchangeForm(id,text){
    $("#exitExchange_id").val(id);
    $("#exitExchange_text").html(text);
}

function deleteExchangeForm(id,text){
    $("#deleteExchange_id").val(id);
    $("#deleteExchange_text").html(text);
}