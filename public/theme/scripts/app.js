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
                    window.OpenWindow = window.open('', 'post.preview', 'location=no,width=1024,height=768,scrollbars=yes,top=100,left=700,resizable = no');
                    $(OpenWindow.document.body).ready(function () {
                        $(OpenWindow.document.body).html(response.html);
                        $(OpenWindow.document).on('click', function(){
                            return false;
                        });
                        $(OpenWindow.document).find('body').append('<div class="disabled-overlay"></div>');
                        OpenWindow.fotorama = function() {
                            var parent = $(OpenWindow.document).find('.js-gallery');
                            var settings = {
                                nav: 'thumbs',
                                arrows: 'always',
                                click: false,
                                loop: true,
                                width: '100%',
                                height: '100%',
                                minHeight: '300px',
                                maxHeight: '500px',
                                fit: 'contain'
                            };
                            var fotoramaDiv = parent.fotorama(settings);
                            var fotorama = fotoramaDiv.data('fotorama');
                        }
                        OpenWindow.ava = function() {
                            var parent = $(OpenWindow.document).find('[data-empty-name]');
                            if(!parent.length) return;
                            parent.each(function(){
                                var name = $(this).attr('data-empty-name');
                                var name_split = name.split(' ');
                                var str = '';
                                $.each(name_split, function(index, value){
                                    str += value.charAt(0);
                                });
                                $(this).find('.js-empty-chars').html(str);
                            });
                        }
                        OpenWindow.fotorama();
                        OpenWindow.ava();
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