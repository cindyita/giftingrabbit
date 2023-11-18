$(document).ready(function () {

    $("#newExchangeForm").submit(function (event) {
        event.preventDefault();
        if (!validateForm('newExchangeForm')) {
            return;
        }
        if ($("#min_price").val() > $("#max_price").val()) {
            message("error", "El precio mínimo no puede ser mayor al precio máximo");
            return;
        }
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
                    showConfetti();
                    hideModal('newExchange');
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
                    showConfetti();
                    updateExchanges();
                } else if (res == 2) {
                    message("error", "El código es inválido");
                } else if (res == 3) {
                    message("error", "No hay ningún intercambio con ese código");
                } else if (res == 4) {
                    message("warning", "Ya te has unido al intercambio");
                } else if (res == 9) {
                    message("error", "Este intercambio ya se ha sorteado, no puedes unirte.");
                } else if (res == 11) {
                    message("error", "Este intercambio tiene las entradas bloqueadas, no puedes unirte.");
                } else {
                    message("error", "Error uniendote al intercambio :(");
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

/* The code snippet is binding a keydown event to all elements with the class "control-next" within the
document. When the user presses the Tab key (keyCode 9), the event handler function is triggered. */
$(document).on('keydown', '.control-next', function(e) {
    if (e.which === 9) {
        e.preventDefault();
        var formControls = $('.control-next');
        var currentIndex = formControls.index(this);
        var nextIndex = (currentIndex + 2) % formControls.length;
        formControls.eq(nextIndex).focus();
    }
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


function fastRaffleaddInput() {
    var newInputs = '<div class="mb-3 mt-3 group">' +
                        '<div class="d-flex gap-2 align-items-center">' +
                            '<input type="text" class="form-control control-next fr-element">' +
                            '<span class="text-primary"><i class="fa-solid fa-chevron-right"></i></span>' +
                            '<input type="text" class="form-control control-next fr-response"><a onclick="removeInputGroup(this)"><i class="fa-solid fa-circle-xmark text-danger cursor-pointer"></i></a>' +
                        '</div>' +
                    '</div>';

    $("#fastRaffle-inputs").append(newInputs);
}

function removeInputGroup(button) {
    $(button).closest('.group').remove();
}

function fastRaffle(event) {
    event.preventDefault();
    $("#fastRaffle-btn").html('<div class="spinner-border"></div>');

    var elements = $(".fr-element");
    var responses = $(".fr-response");

    if (elements.length > 0 && responses.length > 0) {
        var resultados = [];
        var indexElement = Array.from({ length: elements.length }, (_, i) => i);
        var indexResponse = Array.from({ length: responses.length }, (_, i) => i);

        elements.each(function (e) {

            var element = elements.eq(e).val();
            var response = responses.eq(e).val();
            
            if (element != "" && response != "") {

                var attempts = 0;
                var maxAttempts = indexElement.length * indexResponse.length;
                
                do {
                    var attemptsResponse = 0;

                    do {
                        var newIndexResponse = getRandomIndex(indexResponse);
                        attemptsResponse++;
                    } while (newIndexResponse == null && attemptsResponse < maxAttempts * 2)
                    
                    if (element != newResponse) {
                        indexResponse[newIndexResponse] = null;
                        
                        var newResponse = responses.eq(newIndexResponse).val();
                    }
                    
                    attempts++;
                }while(element == newResponse && attempts < maxAttempts)

                resultados.push({
                    element: element,
                    response: newResponse
                });
                //console.log(resultados);

                if (element == newResponse) {
                    message("warning", "Hay muy pocas combinaciones únicas. Vuelve a sortear.");
                }
                 
            } else {
                message("warning","Agrega la información completa")
            }
        });

        var newTexts = '';
        resultados.forEach(element => {
            var textRed = "";
            if (element['element'] == element['response']) {
                textRed = "text-danger";
            }
            newTexts += '<div class="mb-3 mt-3">' +
                            '<div class="d-flex gap-2 align-items-center w-100">' +
                                '<span class="fr-element-text '+textRed+'">'+element['element']+'</span>' +
                                '<span class="text-primary"><i class="fa-solid fa-chevron-right"></i></span>' +
                                '<span class="fr-response-text '+textRed+'">'+element['response']+'</span>' +
                            '</div>' +
                        '</div>';
        });

        $("#fastRaffle-texts").append(newTexts);

        $("#fastRaffle-p1").hide();
        $("#fastRaffle-p2").show();

        // console.log(resultados);
        showConfetti();
        
    } else {
        alert("Agrega al menos una entrada en ambos lados antes de realizar el sorteo.");
    }

    $("#fastRaffle-btn").html('Sortear <i class="fa-solid fa-dice"></i>');
}



function getRandomIndex(indices) {
    var randomIndex = Math.floor(Math.random() * indices.length);
    return indices[randomIndex];
}

function showConfetti() {
    confetti({
        particleCount: 150,
        spread: 60,
        zIndex: 2000,
        colors: ["#FF8211", "#64F8A9"]
    });
}

function cleanForm() {
    $("#fastRaffleForm")[0].reset();
}

function fastRaffleReturn() {
    $("#fastRaffle-texts").empty();
    $("#fastRaffle-p2").hide();
    $("#fastRaffle-p1").show();
}

function asignSerieNumbers() {
    var responses = $(".fr-response");
    var count = 1;
    responses.each(function (e) {
        responses.eq(e).val(count);
        count++;
    });
}

