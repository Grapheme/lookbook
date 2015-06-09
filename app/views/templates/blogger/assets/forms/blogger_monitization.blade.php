{{ Form::model($profile,array('route'=>'blogger.monitization.update','method'=>'put', 'class'=>'js-dashboard-form')) }}
<div class="left-title">Монетизация</div>
<div class="form-desc money-block">
    <div class="block__section">
        <div class="section__desc">
            <p>Lookbook предоставляет авторам возможность сделать блог коммерческим проектом. Качественный и интересный контент, а также постоянное использование инструментов шаринга повысят его популярность и позволят начать сотрудничество с брендами. Чем больше у вашего блога подписчиков в социальных сетях, тем выше вероятность его монетизации.</p>
            <p>Отметьте, пожалуйста, какой из вариантов сотрудничества с брендами вам наиболее интересен (возможен интерес к одному, двум или сразу всем трем вариантам сотрудничества)</p>
        </div>
        <div class="section__content">
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>сотрудничество на платной основе</label>
            </div>
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>сотрудничество на бесплатной основе в целях PR</label>
            </div>
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>сотрудничество на бартерной основе</label>
            </div>
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>мне не интересно сотрудничество с брендами</label>
            </div>
        </div>
    </div>
    <div class="block__section">
        <div class="section__desc">Укажите, пожалуйста, некоторые особенности вашего блога</div>
        <div class="section__content">
            <textarea class="redactor dashboard-textarea js-autosize"></textarea>
        </div>
    </div>
    <div class="block__section">
        <div class="section__desc">Основная направленность:</div>
        <div class="section__content">
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>Fashion</label>
            </div>
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>Beauty</label>
            </div>
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>Lifestуle</label>
            </div>
            <div class="check-cont js-set-check">
                <input type="checkbox" class="js-styled-check"><label>Other</label>
            </div>
        </div>
    </div>
    <div class="block__section">
        <div class="section__desc">
            Укажите, пожалуйста, по какому адресу и телефону с вами предпочтительнее всего связаться в случае, если бренд выберет вас для сотрудничества.
        </div>
    </div>
    <table class="dashboard__form-table">
        <tr>
            <td class="form-table__name">Телефон</td>
            <td class="form-table__value js-form-value">
                <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                {{ Form::text('phone',Input::old('blogname'),array('class'=>'dashboard-input')) }}
            </td>
        </tr>
        <tr>
            <td class="form-table__name">Адрес</td>
            <td class="form-table__value js-form-value">
                <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                {{ Form::text('adress',Input::old('blogname'),array('class'=>'dashboard-input')) }}
            </td>
        </tr>
    </table>
    <div class="block__section">
        <div class="section__desc">
            В случае, если  блогер выбирает хоть один из вариантов сотрудничества с брендами, обязательными для заполнения пунктами в профиле становятся все, кроме :  Мои блоги на сторонних ресурсах, Мой сайт, Источники вдохновения, Текст о себе или о блоге.
        </div>
    </div>
</div>
<table class="dashboard__form-table">
    <tr class="form-table__btns">
        <td class="form-table__name"></td>
        <td class="form-table__value">
            {{ Form::button('Сохранить',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
            <div class="response-text js-response-text"></div>
        </td>
    </tr>
</table>
{{ Form::close() }}