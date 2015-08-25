{{ Form::model($profile,array('route'=>'profile.update','method'=>'put','id'=>'dashboard-main', 'class'=>'js-dashboard-form','files'=>TRUE)) }}
    {{ Form::hidden('birth','') }}
    {{ Form::hidden('sex', 0) }}
    {{ Form::hidden('picture') }}
<div class="left-title">Основное</div>
<table class="dashboard__form-table">
    <tr>
        <td class="form-table__name"><span>Название</span></td>
        <td class="form-table__value js-form-value">
            <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
            <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
            {{ Form::text('name',Input::old('name'),array('class'=>'dashboard-input')) }}
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Головной офис</span></td>
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
        <td class="form-table__name"><span>Специализация</span></td>
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
@if(0)
<form action="/json/tags.json" class="js-tags-form">
    <div class="left-title">Теги</div>
    <table class="dashboard__form-table form-tags js-tags-cont">
        <tr class="tags__item js-tags-item">
            <td class="form-table__name">
                <input class="name__input" type="file" name="tag_photos[]"></input>
                <div class="name__hover">
                    <span>Загрузить<br>изображение</span>
                </div>
                <div class="name__image js-tags-image" style="background-image: url(http://www.keenthemes.com/preview/metronic/theme/assets/global/plugins/jcrop/demos/demo_files/image1.jpg)"></div>
            </td>
            <td class="form-table__value">
                <input name="tags[]" class="dashboard-input" value="Fashion" placeholder="Имя тега">
                <a href="#" data-action="/json/test.json" data-tag-id="2" class="value__delete js-tag-delete"></a>
            </td>
        </tr>
    </table>
    <table class="dashboard__form-table">
        <tr class="tags__item js-tags-item js-tag-sample" style="display: none;">
            <td class="form-table__name">
                <input class="name__input js-tags-input" type="file" name="tag_photos[]"></input>
                <div class="name__hover">
                    <span class="js-tags-filename">Загрузить<br>изображение</span>
                </div>
            </td>
            <td class="form-table__value">
                <input name="tags[]" class="dashboard-input" placeholder="Имя тега">
                <a href="#" data-action="json/test.json" class="value__delete js-tag-delete"></a>
            </td>
        </tr>
        <tr class="tags__add">
            <td class="form-table__name" colspan="2">
                <a href="#" class="us-link js-add-tag">Добавить</a>
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
</form>
@endif