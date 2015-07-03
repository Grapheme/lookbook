/* jshint devel:true */

window.LookBook = {};
window.Help = {};
window.jQuery.fn.autosize = function() {
    return autosize(this);
};
Help.getRandomInt = function(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
Help.getRandomArbitrary = function(min, max) {
    return Math.random() * (max - min) + min;
}
Help.avaGenerator = function() {
    var parent = $('[data-empty-name]');
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
Help.typicalSubmit = function() {
    $(document).on('submit', '.js-ajax-form', function(e){
        var form = $(this);
        Help.ajaxSubmit(form);
        e.preventDefault();
        return false;
    });
}
Help.ajaxSubmit = function(form, callbacks) {
    var response_cont = $(form).find('.js-response-text'),
        options = { 
        beforeSubmit: function(){
            response_cont.hide();
            $(form).find('[type="submit"]').addClass('loading')
                .attr('disabled', 'disabled');
        }, 
        success: function(data){
            if(data.status && data.redirect && data.redirect != '') {
                window.location.href = data.redirect;
            }
            $(form).find('[type="submit"]').removeClass('loading')
                .removeAttr('disabled');
            if(callbacks && callbacks.success) {
                callbacks.success(data);
            }
            if($(form).hasClass('js-reg-form')) {
                $('.js-full-reg').slideUp();
                $('.js-final-text').html(data.responseText);
            } else if(data.responseText) {
                response_cont.show().html(data.responseText);
            }
        },
        error: function(data) {
            response_cont.show().text('Ошибка на сервере, попробуйте позже');
            $(form).find('[type="submit"]').removeClass('loading')
                .removeAttr('disabled');
        }
    };
    $(form).ajaxSubmit(options);
}
Help.avaCrop = function() {
    var crop_cont = $('.js-crop-ava > img');
    $('.js-crop-ava > img').cropper({
        aspectRatio: 1,
        minCropBoxWidth: 50,
        minCropBoxHeight: 50,
        preview: $('.js-crop-preview'),
        crop: function(data) {
        }
    });
}
Help.uploadPhoto = function(input) {
    file = input[0].files[0];
    fr = new FileReader();
    $('#ava-error-cont').html('').hide();
    fr.onload = function(e) {
        $('.js-image-test').remove();
        var image_str = '<img src="' + e.target.result + '">';
        var image_test = '<img class="js-image-test" style="position: fixed; left: -9999px;" src="' + e.target.result + '">';
        $('html').append(image_test);
        var img_width = $('.js-image-test').width();
        var img_height = $('.js-image-test').height();
        $('.js-crop-ava').html(image_str);
        $('.js-ava-overlay').show();
        Help.avaCrop();
        input.val('');
    }
    fr.readAsDataURL(file);
}
Help.avaSubmit = function(form, callback) {
    var response_cont = $('#ava-error-server'),
        options = { 
            beforeSubmit: function(){
                response_cont.hide();
                response_cont.text('Загрузка...');
            }, 
            success: function(data){
                if(data.responseText) {
                    response_cont.show().text(data.responseText);
                }
                callback(data);
            },
            error: function(data) {
                response_cont.show().text('Ошибка на сервере, попробуйте позже');
            }
        };
    $(form).ajaxSubmit(options);
}
jQuery.extend(jQuery.validator.messages, {
    required: "Это поле необходимо заполнить.",
    remote: "Пожалуйста, введите правильное значение.",
    email: "Пожалуйста, введите корретный адрес электронной почты.",
    url: "Пожалуйста, введите корректный URL.",
    date: "Пожалуйста, введите корректную дату.",
    dateISO: "Пожалуйста, введите корректную дату в формате ISO.",
    number: "Пожалуйста, введите число.",
    digits: "Пожалуйста, вводите только цифры.",
    creditcard: "Пожалуйста, введите правильный номер кредитной карты.",
    equalTo: "Пароли не совпадают",
    accept: "Пожалуйста, выберите файл с правильным расширением.",
    maxlength: jQuery.validator.format("Пожалуйста, введите не больше {0} символов."),
    minlength: jQuery.validator.format("Пожалуйста, введите не меньше {0} символов."),
    rangelength: jQuery.validator.format("Пожалуйста, введите значение длиной от {0} до {1} символов."),
    range: jQuery.validator.format("Пожалуйста, введите число от {0} до {1}."),
    max: jQuery.validator.format("Пожалуйста, введите число, меньшее или равное {0}."),
    min: jQuery.validator.format("Пожалуйста, введите число, большее или равное {0}."),
    extension: jQuery.validator.format("Вы можете загрузить изображение только со следующими расширениями: jpeg, jpg, png, gif.")
});
LookBook.SimpleSlide = function() {
    if(!$('.js-slide-item').length) return;
    $('.js-slide-link').on('click', function(){
        $(this).parents('.js-slide-parent').find('.js-slide-item').slideDown();
        $(this).parent().slideUp();
        return false;
    });
}
LookBook.UiButton = function() {
    if(!$('.js-set-check').length) return;
    var parent = $('.js-set-check');
    var this_id = 0;
    var id_strign = 'ui-check-';
    parent.each(function(){
        var this_string = id_strign + this_id
        $(this).find('[type="checkbox"]').attr('id', this_string);
        $(this).find('label').attr('for', this_string);
        this_id++;
    });
}
LookBook.Search = function() {
    $('.js-open-search').on('click', function(){
        $('.js-search-form input[type="text"]').trigger('focus');
        $('.js-search').addClass('active');
    });
    $('.js-close-search').on('click', function(){
        $('.js-search').removeClass('active');
    });
    $('.js-search-form').on('submit', function(){
        var input = $(this).find('input[type="text"]');
        if(input.val() == '') {
            input.trigger('focus');
            return false;
        }
    });
}
LookBook.Gallery = function() {
    if(!$('.js-gallery').length) return;
    var parent = $('.js-gallery');
    var parent_full = $('.js-gallery-full');
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
    var settings_full = {
        nav: false,
        arrows: 'always',
        loop: true,
        width: '100%',
        height: '100%',
        fit: 'contain'
    };
    var fotoramaDiv = parent.fotorama(settings);
    var fotorama = fotoramaDiv.data('fotorama');
    var fotoramaDiv_full = parent_full.fotorama(settings_full);
    var fotorama_full = fotoramaDiv_full.data('fotorama');
    parent.on('click', '.fotorama__stage__shaft', function(){
        $('.js-gallery-overlay').show();
        if(!fotorama_full) {
            fotorama_full = fotoramaDiv_full.data('fotorama');
        }
        if(fotorama_full) {
            fotorama_full.show(fotorama.activeIndex);
        }
    });
    $('.js-gallery-close').on('click', function(){
        $('.js-gallery-overlay').fadeOut('fast');
        return false;
    });
    parent_full.on('fotorama:show', function (e, ftr) {
            fotorama.show(ftr.activeIndex);
        }
    );
}
LookBook.ActionButton = function() {
    if(!$('.js-action-btn').length) return;
    $('.js-action-btn').on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        var response_cont = form.find('[type="submit"]'),
            options = { 
            beforeSubmit: function(){
                response_cont.addClass('loading');
            }, 
            success: function(data){
                if(data.responseText) {
                    response_cont.text(data.responseText);
                }
                response_cont.removeClass('loading').attr('disabled', 'disabled');
            },
            error: function(data) {
                response_cont
                    .text('Ошибка на сервере')
                    .removeClass('loading');
            }
        };
        $(form).ajaxSubmit(options);
        return false;
    });
}
LookBook.CommentForm = function() {
    var parent = $('.js-comment-form');
    if(!parent.length) return;
    var textarea = parent.find('textarea');
    textarea.on('keydown', function(e){
        if(e.keyCode == 13 && !e.shiftKey) {
            parent.trigger('submit');
            return false;
        }
    });
    parent.on('submit', function(e){
        e.preventDefault();
        if(textarea.val().trim().length < 1) {
            return false;
        } else {
            Help.ajaxSubmit(parent, {
                success: function(data){
                    $('.js-comments').prepend(data.html);
                    textarea.val('').removeAttr('style');
                    Help.avaGenerator();
                }
            });
        }
    });
}
LookBook.Dashboard = function() {
    var postDelete = function(form) {
        var post_cont = form.parents('.js-post').first(),
            options = { 
            beforeSubmit: function(){
                post_cont.addClass('opacity05');
                $(form).find('[type="submit"]').attr('disabled', 'disabled');
            }, 
            success: function(data){
                if(data.status) {
                    post_cont.slideUp();
                } else {
                    //console.log(data);
                }
            },
            error: function(data) {
                post_cont.removeClass('opacity05');
                $(form).find('[type="submit"]').removeAttr('disabled');
                //console.log(data);
            }
        };
        form.ajaxSubmit(options);
    }
    var postsGet = function(form) {
        var response_cont = form.find('.js-response-text');
        var posts_cont = $('.js-posts'),
            options = { 
            beforeSubmit: function(){
                response_cont.hide();
                form.find('[type="submit"]').addClass('loading')
                    .attr('disabled', 'disabled');
            }, 
            success: function(data){
                //console.log(posts_cont);
                posts_cont.append(data.html);
                if(data.hide_button) {
                    form.hide();
                }
                $('#js-input-from').val(data.from);
                form.find('[type="submit"]').removeClass('loading')
                    .removeAttr('disabled');
            },
            error: function(data) {
                response_cont.show().text('Ошибка на сервере, попробуйте позже');
                form.find('[type="submit"]').removeClass('loading')
                    .removeAttr('disabled');
            }
        };
        form.ajaxSubmit(options);
    }
    $(document).on('submit', '.js-delete-post', function(){
        postDelete($(this));
        return false;
    });
    $(document).on('submit', '.js-more-posts', function(){
        postsGet($(this));
        return false;
    });
}
LookBook.ContactForm = function() {
    var form = $('.js-contact-form');
    if(!form.length) return;
    form.validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true
            },
        },
        submitHandler: function(form) {
            Help.ajaxSubmit(form, {
                success: function() {
                    $(form).slideUp();
                    $('.js-contact-success').slideDown();
                }
            });
            return false;
        }
    });
}
LookBook.DashForm = function() {
    var formParent = $('.js-dashboard-form');
    if(!formParent.length) return;
    var value_block = $('.js-form-value');
    var focusClick = function(elem) {
        var parent = elem.parents('.js-form-value');
        parent.find('input').trigger('focus');
    }
    var inputFocus = function(elem) {
        var parent = elem.parents('.js-form-value');
        parent.addClass('focus-value');
    }
    var inputFocusOut = function(elem) {
        var parent = elem.parents('.js-form-value');
        parent.removeClass('focus-value');
        checkInputs();
    }
    var checkInputs = function(elem) {
        value_block.each(function(){
            var this_block = $(this);
            var input = $(this).find('input');
            if(input.val() == '') {
                this_block.addClass('empty-value');
            } else {
                this_block.removeClass('empty-value');
            }
        });
    }
    var avaUpload = function(form) {
        Help.uploadPhoto(form.find('input[type="file"]'));
    }
    var init = function() {
        checkInputs();
        $(document).on('click', '.js-add-value', function(){
            focusClick($(this));
            return false;
        });
        $('.js-ava-overlay-close, .js-ava-overlay .overlay__background').on('click', function(e){
            $('.js-ava-overlay').hide();
            return false;
        });
        value_block.find('input').on('focus', function(){
            inputFocus($(this));
        });
        value_block.find('input').on('focusout', function(){
            inputFocusOut($(this));
        });
        $('a').on('focus', function(){
            if($(this).parents('.js-form-value').length)
                focusClick($(this));
        });
        $('#dashboard-main').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            },
            errorPlacement: function(label,element) {
                element.parents('tr').addClass('error');
            },
            success: function(label,element) {
                $(element).parents('tr').removeClass('error');
            },
            submitHandler: function(form) {
                Help.ajaxSubmit(form);
                return false;
            }
        });
        $('#dashboard-pass').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#dashboard-pass [name='password']"
                }
            },
            errorPlacement: function(label,element) {
                element.parents('tr').addClass('error');
            },
            success: function(label,element) {
                $(element).parents('tr').removeClass('error');
            },
            submitHandler: function(form) {
                Help.ajaxSubmit(form);
                return false;
            }
        });
        var avaIds = ['#ava-upload', '#ava-change'];
        $.each(avaIds, function(index, value){
            $(value).find('input[type="file"]').on('change', function(){
                $('#ava-error-server').html('');
                $(this).parents(value).trigger('submit');
            });
        });
        $('#ava-delete').find('.js-submit').on('click', function(){
            $('#ava-error-server').html('');
            $(this).parents('#ava-delete').trigger('submit');
        });
        $('#ava-change').validate({
            rules: {
                photo: {
                    required: true,
                    extension: "jpg|jpeg|png|gif"
                }
            },
            errorElement : 'div',
            errorLabelContainer: '#ava-error-cont',
            submitHandler: function(form) {
                avaUpload($('#ava-change'));
                // Help.avaSubmit(form, function(data){
                //     $('.js-ava-cont').removeClass('ava-empty');
                //     $('.js-ava-img-cont').html('<img src="' + data.image + '" alt="">');
                // });
                return false;
            }
        });
        $('#ava-upload').validate({
            rules: {
                photo: {
                    required: true,
                    extension: "jpg|jpeg|png|gif"
                }
            },
            errorElement : 'div',
            errorLabelContainer: '#ava-error-cont',
            submitHandler: function(form) {
                avaUpload($('#ava-upload'));
                // Help.avaSubmit(form, function(data){
                //     $('.js-ava-cont').removeClass('ava-empty');
                //     $('.js-ava-img-cont').html('<img src="' + data.image + '" alt="">');
                // });
                return false;
            }
        });
        $('#ava-delete').validate({
            rules: {},
            errorElement : 'div',
            errorLabelContainer: '#ava-error-cont',
            submitHandler: function(form) {
                Help.avaSubmit(form, function(data){
                    $('.js-ava-cont').addClass('ava-empty');
                    $('.js-ava-img-cont').html('');
                });
                return false;
            }
        });
        $('#ava-crop-upload').on('submit', function(e){
            e.preventDefault();
            var form = $(this);
            var this_image = $('.js-crop-ava > img').cropper('getCroppedCanvas').toDataURL();
            form.find('input[name="photo"]').val(this_image);
            Help.ajaxSubmit(form, {
                success: function(data) {
                    $('.js-ava-cont').each(function(){
                        $(this).removeClass('ava-empty');
                        var img_cont = $(this).find('.js-ava-img-cont');
                        var img_str = '<img alt="" src="' + data.image + '">';
                        if(img_cont.length) {
                            img_cont.html(img_str);
                        } else {
                            $(this).find('img').remove();
                            $(this).append(img_str);
                        }
                    });
                    $('.js-ava-overlay').hide();
                }
            });
        });
    }
    init();
}
LookBook.FitText = function() {
    $.fn.fitText = function() {
        var parent = $(this).parents('.js-fit-parent'),
            elem = $(this);
        while(elem.width() > parent.width()) {
            var new_size = parseInt(elem.css('font-size')) - 1 + 'px';
            elem.css({
                'font-size': new_size
            });
        }
    }
    $('.js-fit-text').fitText();
}
LookBook.Auth = function() {
    var parent = this,
        overlay = $('.js-overlay'),
        background = overlay.find('.overlay__background'),
        auth_tab = overlay.find('[data-popup]'),
        close_link = $('.js-close-popup'),
        transTime = 500;
    this.show = function(name){
        var turnon = auth_tab.filter('[data-popup="' + name + '"]');
        if(!turnon.length) return;
        turnon.siblings().removeClass('active').hide();
        overlay.show();
        $('html').addClass('locked');
        setTimeout(function(){
            background.addClass('active');
            turnon.show();
            setTimeout(function(){
                turnon.addClass('active');
            }, 50);
        }, 50);
    }
    this.close = function() {
        window.location.hash = '';
        auth_tab.removeClass('active');
        background.removeClass('active');
        $('html').removeClass('locked');
        setTimeout(function(){
            auth_tab.hide();
            overlay.hide();
        }, transTime);
    }
    this.hashOpen = function() {
        var name = window.location.hash.substring(1);
        if(name != '') {
            parent.show(name);
        }
    }
    close_link.on('click', function(){
        parent.close();
        return false;
    });
    $(window).on('hashchange', function(){
        parent.hashOpen();
    });
    this.hashOpen();
    $('#form-auth').validate({
        rules: {
            login: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        submitHandler: function(form) {
            Help.ajaxSubmit(form);
            return false;
        }
    });
    $('#form-reg').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_verify: {
                required: true,
                equalTo: "#form-reg [name='password']"
            },
            name: {
                required: true
            }
        },
        submitHandler: function(form) {
            Help.ajaxSubmit(form);
            return false;
        }
    });
    $('#form-restore_before').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        submitHandler: function(form) {
            Help.ajaxSubmit(form);
            return false;
        }
    });
    $('#form-restore').validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: "#form-restore [name='password']"
            }
        },
        submitHandler: function(form) {
            Help.ajaxSubmit(form);
            return false;
        }
    });
}
LookBook.TopSplit = function() {
    if(!$('.js-top-split').length) return;
    var items = $('.js-top-split >li'),
        wrapArray = [],
        arrayStep = 0,
        item_on_page = 6;
        add_class = '';
    if($('.js-top-split').hasClass('js-collage')) {
        $('.js-collage').removeClass('js-collage');
        add_class = ' js-collage';
    }
    for(var i = 0; i < items.length / item_on_page; i++) {
        var elemObj = $();
        var fromIndex = i * item_on_page;
        for(j = fromIndex; j < fromIndex + item_on_page; j++) {
            if(items.eq(j).length) {
                elemObj.push(items.eq(j)[0]);
            }
        }
        wrapArray.push(elemObj);
    }
    $.each(wrapArray, function(index, value){
        value.wrapAll('<ul class="posts-slider js-list-slide' + add_class + ' clearfix" />');
    });
    $('.js-top-split').css('height', $('.js-top-split .posts-slider').first().outerHeight(true));
}
LookBook.TopCollage = function() {
    if(!$('.js-collage').length) return;
    if($('.js-collage li').length > 3) {
        var options = [
            {
                x: [0, 60],
                y: [0, 35]
            },
            {
                x: [-35, 35],
                y: [0, 35]
            },
            {
                x: [0, -35],
                y: [0, 35]
            },
            {
                x: [0, 60],
                y: [-35, 0]
            },
            {
                x: [-35, 35],
                y: [-35, 0]
            },
            {
                x: [0, -35],
                y: [-35, 0]
            }
        ];
    } else {
        var options = [
            {
                x: [0, 60],
                y: [-5, 5]
            },
            {
                x: [-35, 35],
                y: [-5, 5]
            },
            {
                x: [0, -35],
                y: [-5, 5]
            }
        ];
    }
    setTimeout(function(){
        $('.js-collage').addClass('active');
        setTimeout(function(){
            $('.js-collage').addClass('fast-animation');
        }, 1000)
    }, 50);
    $('.js-collage').each(function(){
        var this_items = $(this).find('li');
        $.each(options, function(index, value){
            var this_x = Help.getRandomInt(value.x[0], value.x[1]);
            var this_y = Help.getRandomInt(value.y[0], value.y[1]);
            var this_scale = Help.getRandomArbitrary(0.6, 0.95);
            var transform_str = 'transform: translate(' + this_x + '%, ' + this_y + '%) scale(' + this_scale + '); z-index: 1;';
            var transform_hover = 'transform: translate(' + this_x + '%, ' + this_y + '%) scale(1); z-index: 5;';
            //console.log(transform_str);
            this_items.eq(index)
                .attr('style', transform_str)
                .attr('data-static-style', transform_str)
                .attr('data-hover-style', transform_hover);
        });
    });
    $('.js-collage li')
    .on('mouseenter', function(){
        $(this).attr('style', $(this).attr('data-hover-style'));
    })
    .on('mouseleave', function(){
        $(this).attr('style', $(this).attr('data-static-style'));
    });
}
LookBook.ListSlider = function() {
    if(!$('.js-list-slider').length) return;
    $('.js-list-slider').each(function(){
        var parent = $(this),
            item = parent.find('.js-list-slide'),
            dots_parent = parent.find('.js-list-dots'),
            classes = ['to-left', 'to-right', 'out-left', 'out-right'];
        var show = function(id) {
            var this_item = item.eq(id);
            parent.find('.js-list-dot').eq(id).addClass('active')
                .siblings().removeClass('active');
            item.removeClass(classes.join(' '));
            this_item.prev().addClass('to-left')
                .prevAll().addClass('out-left');
            this_item.next().addClass('to-right')
                .nextAll().addClass('out-right');
        }
        var setEvents = function() {
            item.on('click', function(){
                if($(this).hasClass('to-right') || $(this).hasClass('to-left')) {
                    show($(this).index());
                    return false;
                }
            });
            parent.find('.js-list-dot').on('click', function(){
                show($(this).index());
                return false;
            });
        }
        var init = function() {
            if(item.length > 1) {
                item.each(function(){
                    dots_parent.append('<a href="#" class="nav__dot js-list-dot"></a>');
                });
                setTimeout(function(){
                    item.addClass('with-transition');
                }, 50);
            } else {
                dots_parent.remove();
            }
            show(0);
            setEvents();
        }
        init();
    });
}
LookBook.DatePicker = function() {
    $('.js-datepicker').datepicker();
}
LookBook.Like = function() {
    var sendLike = function(elem) {
        var action = elem.attr('data-action');
        $.ajax({
            url: action,
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            console.log(data);
        }).fail(function(data){
            console.log(data);
        });
    }
    var init = function() {
        $(document).on('click', '.js-like', function(){
            sendLike($(this));
            return false;
        });
    }
    init();
}
LookBook.Mask = function() {
    if(!$('[data-mask]').length) return;
    $('[data-mask]').each(function(){
        var settings = {};
        if($(this).attr('data-placeholder')) {
            settings.placeholder = $(this).attr('data-placeholder');
        }
        $(this).mask($(this).attr('data-mask'), settings);
    });
}
LookBook.init = function() {
    Help.avaGenerator();
    Help.typicalSubmit();
    LookBook.Dashboard();
    LookBook.DatePicker();
    LookBook.TopSplit();
    LookBook.ListSlider();
    LookBook.TopCollage();
    LookBook.DashForm();
    LookBook.ContactForm();
    LookBook.CommentForm();
    LookBook.Gallery();
    LookBook.Search();
    LookBook.FitText();
    LookBook.Auth();
    LookBook.ActionButton();
    LookBook.UiButton();
    LookBook.SimpleSlide();
    LookBook.Mask();
    $('.js-autosize').autosize();
    $('.js-styled-select').selectmenu();
    $('.js-styled-check').button();
}

$(LookBook.init);