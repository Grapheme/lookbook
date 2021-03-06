{{ Form::model($profile,array('route'=>'profile.update','method'=>'put','id'=>'dashboard-main', 'class'=>'js-dashboard-form')) }}
<div class="left-title">Основное</div>
<table class="dashboard__form-table">
    <tr>
        <td class="form-table__name"><span>Имя</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('name',Input::old('name'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Дата рождения</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('birth',Input::old('birth'),array('class'=>'dashboard-input', 'data-mask'=>'99.99.9999', 'data-placeholder'=>'__.__.____')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Пол</span></td>
        <td class="form-table__value js-form-value">
            {{ Form::select('sex',array('Не выбрано','Мужской','Женский'),NULL,array('class'=>'js-styled-select')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Местонахождение</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('location',Input::old('location'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Мои блоги на сторонних ресурсах<br><i>(через запятую)</i></span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('links',Input::old('links'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Мой сайт</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('site',Input::old('site'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Источники вдохновения</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('inspiration',Input::old('inspiration'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
</table>
<div class="left-title">Для связи со мной</div>
<table class="dashboard__form-table">
    <tr>
        <td class="form-table__name"><span>Электронная почта</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('contact_email',Input::old('contact_email'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Телефон</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('phone',Input::old('phone'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
</table>
<div class="left-title">О блоге</div>
<table class="dashboard__form-table">
    <tr>
        <td class="form-table__name"><span>Название блога</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('blogname',Input::old('blogname'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Ссылка на блог</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('nickname',Input::old('nickname'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Текст о себе или о блоге</span></td>
        <td class="form-table__value form-table__texarea-cont">
            {{ Form::textarea('about',Input::old('about'),array('class'=>'redactor dashboard-textarea js-autosize')) }}
        </td>
    </tr>
    <tr class="form-table__btns">
        <td class="form-table__name"></td>
        <td class="form-table__value">
            {{ Form::button('Сохранить',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
            <div class="response-text js-response-text"></div>
        </td>
    </tr>
</table>
{{ Form::close() }}