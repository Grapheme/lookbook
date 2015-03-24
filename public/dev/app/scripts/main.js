/* jshint devel:true */

window.LookBook = {};
window.Help = {};
window.jQuery.fn.autosize = function() {
    return autosize(this);
};
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
Help.ajaxSubmit = function(form) {
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
            if(data.responseText) {
                response_cont.show().text(data.responseText);
            }
            $(form).find('[type="submit"]').removeClass('loading')
                .removeAttr('disabled');
        },
        error: function(data) {
            response_cont.show().text('Ошибка на сервере, попробуйте позже');
            $(form).find('[type="submit"]').removeClass('loading')
                .removeAttr('disabled');
        }
    };
    $(form).ajaxSubmit(options);
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
    var init = function() {
        checkInputs();
        $(document).on('click', '.js-add-value', function(){
            focusClick($(this));
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
                Help.avaSubmit(form, function(data){
                    $('.js-ava-cont').removeClass('ava-empty');
                    $('.js-ava-img-cont').html('<img src="' + data.image + '" alt="">');
                });
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
                Help.avaSubmit(form, function(data){
                    $('.js-ava-cont').removeClass('ava-empty');
                    $('.js-ava-img-cont').html('<img src="' + data.image + '" alt="">');
                });
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

$(function(){
    Help.avaGenerator();
    LookBook.DashForm();
    LookBook.FitText();
    LookBook.Auth();
    $('.js-autosize').autosize();
});
