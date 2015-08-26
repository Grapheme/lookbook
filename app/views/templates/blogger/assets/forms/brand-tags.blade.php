{{ Form::model($profile, array('route'=>'brand.tags.update','method'=>'put', 'class'=>'js-tags-form','files'=>TRUE)) }}
<div class="left-title">Теги</div>
<table class="dashboard__form-table form-tags js-tags-cont">
    <tr class="tags__item js-tags-item">
        <td class="form-table__name">
            <input class="name__input" type="file" name="tag_photos[]">

            <div class="name__hover">
                <span>Загрузить<br>изображение</span>
            </div>
            <div class="name__image js-tags-image"
                 style="background-image: url(http://www.keenthemes.com/preview/metronic/theme/assets/global/plugins/jcrop/demos/demo_files/image1.jpg)"></div>
        </td>
        <td class="form-table__value">
            <input name="tags[]" class="dashboard-input" value="Fashion" placeholder="Имя тега">
            <a href="#" data-action="{{ URL::route('brand.tags.delete') }}" data-tag-id="2" class="value__delete js-tag-delete"></a>
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
{{ Form::close() }}
