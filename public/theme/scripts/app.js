/**
 * Created by Vladimir on 26.03.2015.
 */
$(document).ready(function () {

    $(".btn-preview").click(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: $($(this).parents('form')).formSerialize(),
            dataType: 'json',
            success: function(response){
                if (response.status) {
                    var OpenWindow = window.open('', 'post.preview', 'location=no,width=1024,height=768,scrollbars=yes,top=100,left=700,resizable = no');
                    $(OpenWindow.document.body).ready(function () {
                        $(OpenWindow.document.body).append(response.html);
                    });
                }
            }
        })
    });
    if($("#auto-save").length){
        setInterval(function(){
            var _this = $("#auto-save");
            $.ajax({
                type: "POST",
                url: $(_this).data('url'),
                data: $($(_this).parents('form')).formSerialize(),
                dataType: 'json',
                success: function(response){
                    if (response.status) {
                        $(_this).html(response.responseText).show().fadeOut('slow');
                    }
                }
            })
        },10000);
    }
});