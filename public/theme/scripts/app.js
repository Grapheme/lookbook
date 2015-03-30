/**
 * Created by Vladimir on 26.03.2015.
 */
$(document).ready(function () {

    $(".btn-preview").click(function (event) {
        event.preventDefault();
        var options = {url: $(this).data('url'), target: null, dataType: 'json', type: 'post'};
        options.beforeSubmit = function (formData, jqForm, options) {},
        options.success = function (response, status, xhr, jqForm) {
            if (response.status) {
                var OpenWindow = window.open('', 'post.preview', 'location=no,width=1024,height=768,scrollbars=yes,top=100,left=700,resizable = no');
                $(OpenWindow.document.body).ready(function () {
                    $(OpenWindow.document.body).append(response.html);
                });
            }
        },
        options.error = function (xhr, textStatus, errorThrown) {
        }
        $($(this).parents('form')).ajaxSubmit(options);
    });
});