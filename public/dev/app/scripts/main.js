/* jshint devel:true */

window.LookBook = {};

LookBook.Auth = function() {
    var parent = this;
    var overlay = $('.js-overlay');
    var background = overlay.find('.overlay__background');
    var auth_tab = overlay.find('[data-popup]');
    var close_link = $('.js-close-popup');
    var transTime = 500;
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
            min: jQuery.validator.format("Пожалуйста, введите число, большее или равное {0}.")
    });
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
            parent.ajaxSubmit(form);
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
            parent.ajaxSubmit(form);
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
            parent.ajaxSubmit(form);
            return false;
        }
    });
    $('#form-restore').validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_verify: {
                required: true,
                equalTo: "#form-restore [name='password']"
            }
        },
        submitHandler: function(form) {
            parent.ajaxSubmit(form);
            return false;
        }
    });
    this.ajaxSubmit = function(form) {
        var response_cont = $(form).find('.js-response-text');
        var options = { 
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
}

$(function(){
    LookBook.Auth();
});
