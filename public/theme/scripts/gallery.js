/**
 * @author: Alexander Zelensky
 * Gallery functionality JS file
 */
function array_merge() {
    //  discuss at: http://phpjs.org/functions/array_merge/
    // original by: Brett Zamir (http://brett-zamir.me)
    // bugfixed by: Nate
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //    input by: josh
    //   example 1: arr1 = {"color": "red", 0: 2, 1: 4}
    //   example 1: arr2 = {0: "a", 1: "b", "color": "green", "shape": "trapezoid", 2: 4}
    //   example 1: array_merge(arr1, arr2)
    //   returns 1: {"color": "green", 0: 2, 1: 4, 2: "a", 3: "b", "shape": "trapezoid", 4: 4}
    //   example 2: arr1 = []
    //   example 2: arr2 = {1: "data"}
    //   example 2: array_merge(arr1, arr2)
    //   returns 2: {0: "data"}

    var args = Array.prototype.slice.call(arguments),
        argl = args.length,
        arg,
        retObj = {},
        k = '',
        argil = 0,
        j = 0,
        i = 0,
        ct = 0,
        toStr = Object.prototype.toString,
        retArr = true;

    for (i = 0; i < argl; i++) {
        if (toStr.call(args[i]) !== '[object Array]') {
            retArr = false;
            break;
        }
    }

    if (retArr) {
        retArr = [];
        for (i = 0; i < argl; i++) {
            retArr = retArr.concat(args[i]);
        }
        return retArr;
    }

    for (i = 0, ct = 0; i < argl; i++) {
        arg = args[i];
        if (toStr.call(arg) === '[object Array]') {
            for (j = 0, argil = arg.length; j < argil; j++) {
                retObj[ct++] = arg[j];
            }
        } else {
            for (k in arg) {
                if (arg.hasOwnProperty(k)) {
                    if (parseInt(k, 10) + '' === k) {
                        retObj[ct++] = arg[k];
                    } else {
                        retObj[k] = arg[k];
                    }
                }
            }
        }
    }
    return retObj;
}

var dropzone_translate = {

    // Dictionary

    // The text used before any files are dropped
    dictDefaultMessage: "Перетяните сюда файлы для загрузки",

    // The text that replaces the default message text it the browser is not supported
    dictFallbackMessage: "Ваш браузер не поддерживает загрузку drag-and-drop",

    // The text that will be added before the fallback form
    // If null, no text will be added at all.
    dictFallbackText: "Пожалуйста, используйте форму ниже, чтобы загрузить файлы.",

    // If the filesize is too big.
    dictFileTooBig: "Cлишком большой файл ({{filesize}}Мб). Максимально допустимый размер: {{maxFilesize}}Мб.",

    // If the file doesn't match the file type.
    dictInvalidFileType: "Данный тип файлов запрещен к загрузке",

    // If the server response was invalid.
    dictResponseError: "Ошибка при загрузке. Код ответа сервера: {{statusCode}}",

    // If used, the text to be used for the cancel upload link.
    dictCancelUpload: "Отменить",

    // If used, the text to be used for confirmation when cancelling upload.
    dictCancelUploadConfirmation: "Вы действительно хотите отменить загрузку?",

    // If used, the text to be used to remove a file.
    dictRemoveFile: "Удалить",

    // If this is not null, then the user will be prompted before removing a file.
    dictRemoveFileConfirmation: null,

    // Displayed when the maxFiles have been exceeded
    // You can use {{maxFiles}} here, which will be replaced by the option.
    dictMaxFilesExceeded: "Достигнут лимит на кол-во загруженных файлов: {{maxFiles}}"
};

$(document).ready(function () {

    Dropzone.autoDiscover = false;

    /*************************************************************************/

    var dz_selector = ".egg-dropzone";

    $(dz_selector).each(function (index, el) {
        //console.log( index + ": " + $( this ).text() );

        var el_name = $(el).data("name");
        var gallery_id = $('#' + el_name + '_gallery_id').val();
        var max_file_size = $(el).data("maxfilesize");
        var max_files = $(el).data("maxfiles");
        var acceptedFiles = $(el).data("acceptedfiles");

        var dropzone_settings = {
            url: base_url + "/admin/galleries/abstractupload",
            addRemoveLinks: true,
            maxFilesize: max_file_size || 2, // MB
            maxFiles: max_files || 0,
            acceptedFiles: acceptedFiles || 'image/*'
        };
        dropzone_settings = array_merge(dropzone_settings, dropzone_translate);

        var myDropzone = new Dropzone(
            el, dropzone_settings
        );

        myDropzone.on("totaluploadprogress", function (data) {
            //console.log(data);
        });

        myDropzone.on("success", function (file, response) {
            //alert(response.image_id);
            $(el).append("<input type='hidden' name='" + el_name + "[uploaded_images][]' value='" + response.image_id + "' id='uploaded_image_" + response.image_id + "' />");
        });

        myDropzone.on("sending", function (file, xhr, formData) {
            //formData.append("filesize", file.size); // Will send the filesize along with the file as POST data.
            //console.log(file);
            //console.log(xhr);
            //console.log(formData);
            formData.append("gallery_id", gallery_id);
        });

        myDropzone.on("removedfile", function (file) {
            //console.log(file);
            // Как-то так...
            if (typeof file.xhr != 'undefined' && typeof file.xhr.response != 'undefined') {
                var image_id = JSON.parse(file.xhr.response).image_id;
                deleteUploadedImage(image_id);
            }
            //return false;
        });

    }); // jQuery.each

    /*************************************************************************/

    var dz_selector = ".egg-dropzone-single";

    $(dz_selector).each(function (index, el) {

        var el_name = $(el).data("name");
        var gallery_id = 0; //$(el).data('gallery_id');
        var preview = $(el).parent().find(".photo-preview");
        var max_file_size = $(el).data("maxfilesize");
        var acceptedFiles = $(el).data("acceptedfiles");

        var dropzone_settings = {
            url: base_url + "/admin/galleries/singleupload",
            addRemoveLinks: true,
            maxFilesize: max_file_size || 2, // MB
            acceptedFiles: acceptedFiles || 'image/*',
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            dictMaxFilesExceeded: 'Можно загрузить только одно изображение.',
            init: function () {
                this.on("addedfile", function () {
                    // Single image upload
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                });
            }
        }
        dropzone_settings = array_merge(dropzone_settings, dropzone_translate);

        var myDropzone = new Dropzone(
            el, dropzone_settings
        );

        myDropzone.on("totaluploadprogress", function (data) {
            //console.log(data);
        });

        myDropzone.on("success", function (file, response) {
            $(el).append("<input type='hidden' name='" + el_name + "' value='" + response.image_id + "' class='uploaded_image_" + response.image_id + "' />");
            $(el).parent().parent().find(".uploaded_image_false").empty().remove();
            $(el).hide();
            $(el).find(".dz-preview").hide();
            $(preview).css("background-image", "url(" + response['thumb'] + ")");
            $(preview).find(".photo-full-link").attr("href", response['full']);
            $(preview).find(".photo-delete-single").attr("data-photo-id", response['image_id']);
            $(preview).show();
            $(preview).parents().find('.photo-preview-container').show();
        });

        myDropzone.on("sending", function (file, xhr, formData) {
            formData.append("gallery_id", gallery_id);
        });

        myDropzone.on("removedfile", function (file) {
            if (typeof file.xhr != 'undefined' && typeof file.xhr.response != 'undefined') {
                var image_id = JSON.parse(file.xhr.response).image_id;
                deleteUploadedImage(image_id);
            }
        });

    });

    /*************************************************************************/

    $('.photo-delete').click(function (event) {
        event.preventDefault();
        var image_id = $(this).attr('data-photo-id');
        var $photoDiv = $(this).parent();
        $.SmartMessageBox({
            title: "Удалить изображение?",
            content: "",
            buttons: '[Нет][Да]'
        }, function (ButtonPressed) {
            if (ButtonPressed == "Да") {
                $.ajax({
                    url: base_url + "/admin/galleries/photodelete",
                    data: {id: image_id},
                    type: 'post'
                }).done(function () {
                    $photoDiv.fadeOut('fast');
                }).fail(function (data) {
                    $photoDiv.fadeOut('fast');
                    console.log(data);
                });
                return false;
            }
        });
        return false;
    });

    $('.photo-delete-single').click(function (event) {
        event.preventDefault();
        var image_id = $(this).attr('data-photo-id');
        var el = $(this).parents('.input');
        var eldz = $(el).find('.egg-dropzone-single');
        var preview = $(el).find('.photo-preview');
        $.SmartMessageBox({
            title: "Удалить изображение?",
            content: "",
            buttons: '[Нет][Да]'
        }, function (ButtonPressed) {
            if (ButtonPressed == "Да") {
                $.ajax({
                    url: base_url + "/admin/galleries/photodelete",
                    data: {id: image_id},
                    type: 'post'
                }).done(function () {
                    $(el).find(".uploaded_image_" + image_id).empty().remove();
                    $(el).append("<input type='text' name='" + eldz.data("name") + "' class='uploaded_image_false uploaded_image_cap' />");

                    $(eldz).removeClass('dz-started');
                    $(eldz).show();
                    $(preview).hide();
                    $(preview).parents('.photo-preview-container').hide();
                }).fail(function (data) {
                    console.log(data);
                });
                return false;
            }
        });
        return false;
    });

    function deleteUploadedImage(image_id) {

        $.ajax({
            url: base_url + "/admin/galleries/photodelete",
            data: {id: image_id},
            type: 'post'
        }).done(function () {
            $(".uploaded_image_" + image_id).empty().remove();
            //$photoDiv.fadeOut('fast');
        }).fail(function (data) {
            console.log(data);
        });
        return false;
    }

});