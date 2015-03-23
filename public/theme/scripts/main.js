window.LookBook={},window.Help={},window.jQuery.fn.autosize=function(){return autosize(this)},Help.avaGenerator=function(){var e=$("[data-empty-name]");e.length&&e.each(function(){var e=$(this).attr("data-empty-name"),a=e.split(" "),t="";$.each(a,function(e,a){t+=a.charAt(0)}),$(this).find(".js-empty-chars").html(t)})},Help.ajaxSubmit=function(e){var a=$(e).find(".js-response-text"),t={beforeSubmit:function(){a.hide(),$(e).find('[type="submit"]').addClass("loading").attr("disabled","disabled")},success:function(t){t.status&&t.redirect&&""!=t.redirect&&(window.location.href=t.redirect),t.responseText&&a.show().text(t.responseText),$(e).find('[type="submit"]').removeClass("loading").removeAttr("disabled")},error:function(){a.show().text("Ошибка на сервере, попробуйте позже"),$(e).find('[type="submit"]').removeClass("loading").removeAttr("disabled")}};$(e).ajaxSubmit(t)},Help.avaSubmit=function(e,a){var t=$("#ava-error-server"),r={beforeSubmit:function(){t.hide(),t.text("Загрузка...")},success:function(e){e.responseText&&t.show().text(e.responseText),a(e)},error:function(){t.show().text("Ошибка на сервере, попробуйте позже")}};$(e).ajaxSubmit(r)},jQuery.extend(jQuery.validator.messages,{required:"Это поле необходимо заполнить.",remote:"Пожалуйста, введите правильное значение.",email:"Пожалуйста, введите корретный адрес электронной почты.",url:"Пожалуйста, введите корректный URL.",date:"Пожалуйста, введите корректную дату.",dateISO:"Пожалуйста, введите корректную дату в формате ISO.",number:"Пожалуйста, введите число.",digits:"Пожалуйста, вводите только цифры.",creditcard:"Пожалуйста, введите правильный номер кредитной карты.",equalTo:"Пароли не совпадают",accept:"Пожалуйста, выберите файл с правильным расширением.",maxlength:jQuery.validator.format("Пожалуйста, введите не больше {0} символов."),minlength:jQuery.validator.format("Пожалуйста, введите не меньше {0} символов."),rangelength:jQuery.validator.format("Пожалуйста, введите значение длиной от {0} до {1} символов."),range:jQuery.validator.format("Пожалуйста, введите число от {0} до {1}."),max:jQuery.validator.format("Пожалуйста, введите число, меньшее или равное {0}."),min:jQuery.validator.format("Пожалуйста, введите число, большее или равное {0}."),extension:jQuery.validator.format("Вы можете загрузить изображение только со следующими расширениями: jpeg, jpg, png, gif.")}),LookBook.DashForm=function(){var e=$(".js-dashboard-form");if(e.length){var a=$(".js-form-value"),t=function(e){var a=e.parents(".js-form-value");a.find("input").trigger("focus")},r=function(e){var a=e.parents(".js-form-value");a.addClass("focus-value")},n=function(e){var a=e.parents(".js-form-value");a.removeClass("focus-value"),o()},o=function(){a.each(function(){var e=$(this),a=$(this).find("input");""==a.val()?e.addClass("empty-value"):e.removeClass("empty-value")})},i=function(){o(),$(document).on("click",".js-add-value",function(){return t($(this)),!1}),a.find("input").on("focus",function(){r($(this))}),a.find("input").on("focusout",function(){n($(this))}),$("a").on("focus",function(){$(this).parents(".js-form-value").length&&t($(this))}),$("#dashboard-main").validate({rules:{name:{required:!0},email:{required:!0,email:!0}},errorPlacement:function(e,a){a.parents("tr").addClass("error")},success:function(e,a){$(a).parents("tr").removeClass("error")},submitHandler:function(e){return Help.ajaxSubmit(e),!1}}),$("#dashboard-pass").validate({rules:{password:{required:!0,minlength:6},password_confirmation:{required:!0,equalTo:"#dashboard-pass [name='password']"}},errorPlacement:function(e,a){a.parents("tr").addClass("error")},success:function(e,a){$(a).parents("tr").removeClass("error")},submitHandler:function(e){return Help.ajaxSubmit(e),!1}});var e=["#ava-upload","#ava-change"];$.each(e,function(e,a){$(a).find('input[type="file"]').on("change",function(){$("#ava-error-server").html(""),$(this).parents(a).trigger("submit")})}),$("#ava-delete").find(".js-submit").on("click",function(){$("#ava-error-server").html(""),$(this).parents("#ava-delete").trigger("submit")}),$("#ava-change").validate({rules:{photo:{required:!0,extension:"jpg|jpeg|png|gif"}},errorElement:"div",errorLabelContainer:"#ava-error-cont",submitHandler:function(e){return Help.avaSubmit(e,function(e){$(".js-ava-cont").removeClass("ava-empty"),$(".js-ava-img-cont").html('<img src="'+e.image+'" alt="">')}),!1}}),$("#ava-upload").validate({rules:{photo:{required:!0,extension:"jpg|jpeg|png|gif"}},errorElement:"div",errorLabelContainer:"#ava-error-cont",submitHandler:function(e){return Help.avaSubmit(e,function(e){$(".js-ava-cont").removeClass("ava-empty"),$(".js-ava-img-cont").html('<img src="'+e.image+'" alt="">')}),!1}}),$("#ava-delete").validate({rules:{},errorElement:"div",errorLabelContainer:"#ava-error-cont",submitHandler:function(e){return Help.avaSubmit(e,function(){$(".js-ava-cont").addClass("ava-empty"),$(".js-ava-img-cont").html("")}),!1}})};i()}},LookBook.FitText=function(){$.fn.fitText=function(){for(var e=$(this).parents(".js-fit-parent"),a=$(this);a.width()>e.width();){var t=parseInt(a.css("font-size"))-1+"px";a.css({"font-size":t})}},$(".js-fit-text").fitText()},LookBook.Auth=function(){var e=this,a=$(".js-overlay"),t=a.find(".overlay__background"),r=a.find("[data-popup]"),n=$(".js-close-popup"),o=500;this.show=function(e){var n=r.filter('[data-popup="'+e+'"]');n.length&&(n.siblings().removeClass("active").hide(),a.show(),$("html").addClass("locked"),setTimeout(function(){t.addClass("active"),n.show(),setTimeout(function(){n.addClass("active")},50)},50))},this.close=function(){window.location.hash="",r.removeClass("active"),t.removeClass("active"),$("html").removeClass("locked"),setTimeout(function(){r.hide(),a.hide()},o)},this.hashOpen=function(){var a=window.location.hash.substring(1);""!=a&&e.show(a)},n.on("click",function(){return e.close(),!1}),$(window).on("hashchange",function(){e.hashOpen()}),this.hashOpen(),$("#form-auth").validate({rules:{login:{required:!0,email:!0},password:{required:!0}},submitHandler:function(e){return Help.ajaxSubmit(e),!1}}),$("#form-reg").validate({rules:{email:{required:!0,email:!0},password:{required:!0,minlength:6},password_verify:{required:!0,equalTo:"#form-reg [name='password']"},name:{required:!0}},submitHandler:function(e){return Help.ajaxSubmit(e),!1}}),$("#form-restore_before").validate({rules:{email:{required:!0,email:!0}},submitHandler:function(e){return Help.ajaxSubmit(e),!1}}),$("#form-restore").validate({rules:{password:{required:!0,minlength:6},password_confirmation:{required:!0,equalTo:"#form-restore [name='password']"}},submitHandler:function(e){return Help.ajaxSubmit(e),!1}})},$(function(){Help.avaGenerator(),LookBook.DashForm(),LookBook.FitText(),LookBook.Auth(),$(".js-autosize").autosize()});