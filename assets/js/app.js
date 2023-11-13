$(window).on("load", function () {
    $(".page-overlay").fadeOut(100);
    changeLogoTheme();
    changeToRelativeTime('relativedate');
    dateFormat('dateFormat');

    if (localStorage.getItem('notice-betaweb') !== 'true') {
        $('#superiorBanner').show();
    }
    $('#closeSuperiorBanner').click(function () {
        $('#superiorBanner').hide();
        localStorage.setItem('notice-betaweb', 'true');
    });

});

/**
 * The function "changeToRelativeTime" converts date values in a specific class to relative time
 * format.
 * @param nameclass - The parameter `nameclass` is a string that represents the class name of the
 * elements you want to change to relative time.
 */
function changeToRelativeTime(nameclass) {
    moment.locale('es');
    $("."+nameclass).each(function (index, element) {
        var dateValue = $(element).text();
        var formattedDate = processDatetime(dateValue,null,1);
        $(element).text(formattedDate);
    });
}

/**
 * The function `dateFormat` takes a class name as input and formats the text content of elements with
 * that class to a specific date format using the Moment.js library.
 * @param nameclass - The parameter "nameclass" is a string that represents the class name of the
 * elements you want to format the date for.
 */
function dateFormat(nameclass) {
    moment.locale('es');
    $("."+nameclass).each(function (index, element) {
        var dateValue = $(element).text();
        var formattedDate = moment(dateValue, 'YYYY-MM-DD').format('D [de] MMMM [de] YYYY');
        $(element).text(formattedDate);
    });
}

/**
 * The dateFormatting function takes an element ID as input, retrieves the text value of that element,
 * and formats it as a date in the 'DD-MM-YYYY' format using the moment.js library.
 * @param id - The parameter "id" is the id of the HTML element that contains the date value you want
 * to format.
 */
function dateFormatting(id) {
    moment.locale('es');
    var dateValue = $('#'+id).text();
    var formattedDate = moment(dateValue, 'YYYY-MM-DD').format('DD-MM-YYYY');
    $('#'+id).text(formattedDate);
}

function dateFormatting2(id) {
    moment.locale('es');
    var dateValue = $('#'+id).text();
    var formattedDate = moment(dateValue, 'YYYY-MM-DD').format('D [de] MMMM [de] YYYY');
    $('#'+id).text(formattedDate);
}


/**
 * The function `processDatetime` converts a given datetime string to a specified format or relative
 * time based on the user's timezone.
 * @param datetime - The datetime parameter is the input datetime value that you want to process. It
 * can be in any valid datetime format.
 * @param [format=null] - The format parameter is used to specify the desired format of the output
 * datetime. It follows the moment.js format syntax. If no format is provided, the function will return
 * the datetime in the default format.
 * @param [relative=false] - The "relative" parameter determines whether the output should be relative
 * to the current time or not. If set to true, the output will be a relative time (e.g. "2 hours ago",
 * "in 3 days"). If set to false, the output will be the formatted datetime string according
 * @returns the processed datetime value based on the provided parameters.
 */
// function processDatetime(datetime, format = null, relative = false) {
//     var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
//     var isoDatetime = moment(datetime, format).toISOString();
//     var newDatetime = moment.tz(isoDatetime, userTimezone);

//     if (relative) {
//         newDatetime = newDatetime.fromNow();
//     }
//     if (format) {
//         newDatetime = newDatetime.format(format);
//     }

//     return newDatetime;
// }
function processDatetime(datetime, format = null, relative = false) {
    var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    var newDatetime = moment.tz(datetime+'Z', userTimezone);

    if (format) {
        newDatetime = newDatetime.format(format);
    }

    if (relative) {
        newDatetime = newDatetime.fromNow();
    }

    return newDatetime;
}

/**
 * The function `changeLogoTheme` changes the source of an image element based on the value of the
 * variable `themeDark`.
 */
function changeLogoTheme() {
    if (!themeDark) {
        $("#imglogo").attr("src", "./assets/img/system/logo.webp");
    } else {
        $("#imglogo").attr("src", "./assets/img/system/logov2.webp");
    }
}

/**
 * The function creates and displays a toast message with different styles based on the type parameter,
 * and automatically fades out after 4 seconds.
 * @param type - The type parameter is a string that represents the type of message. It can be one of
 * the following values: 'success', 'error', or 'warning'.
 * @param text - The "text" parameter is a string that represents the message text that will be
 * displayed in the alert.
 */
function message(type, text) {
    var toast = (type === 'success') ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-warning');
    var title = (type === 'success') ? 'Éxito' : (type === 'error') ? 'Error' : (type === 'warning') ? 'Alerta' : "";

    var html = '<div class="alert-content" id="error-login"><div class="alert-content-flex"><div class="alert-superior alert '+toast+'"><strong> '+title+':</strong> '+text+'</div></div></div>';

    var $message = $(html);
    $message.hide().prependTo('body').fadeIn();
    
    setTimeout(function() {
        $message.fadeOut(function() {
            $(this).remove();
        });
    }, 4000);
    
}

/**
 * The function `handleFileImage` is used to handle and validate an image file, and display a preview
 * of the image.
 * @param files - An array of files that the user has selected. It should contain only one file.
 * @param previewId - The `previewId` parameter is the ID of the HTML element where you want to display
 * the preview of the selected image file.
 * @returns The function does not explicitly return anything.
 */
function handleFileImage(files, previewId) {
    const allowedExtensions = ["jpg", "jpeg", "png", "gif","webp"];
    var preview = $("#" + previewId);
    var file = files[0];

    // Validations
    var maxSizeInBytes = 500 * 1024 * 1024; // 500 MB
    if (file.size > maxSizeInBytes) {
        message("error", "The file '" + file.name + "' exceeds the maximum size allowed");
        return;
    }
    var fileExtension = file.name.split(".").pop().toLowerCase();
    if (allowedExtensions.indexOf(fileExtension) === -1) {
        message("error", "The file '" + file.name + "' does not have an allowed extension");
        return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        preview.attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
}

/**
 * Copies the specified text to the clipboard.
 * @param {string} text - The text to be copied.
 */
function copyToClipboard(text) {
  navigator.clipboard.writeText(text)
    .then(function() {
      message('success', 'Copiado al portapapeles');
    })
    .catch(function() {
      message('error', 'No se pudo copiar');
    });
}

/**
 * The function `hideModal` is used to hide a Bootstrap modal by its ID.
 * @param modal - The parameter "modal" is the ID of the modal element that you want to hide.
 */
function hideModal(modal) {
    var modalElement = document.getElementById(modal);
    var bootstrapModal = bootstrap.Modal.getInstance(modalElement);
    bootstrapModal.hide();
}