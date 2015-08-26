{{ Form::open(array('route'=>'brand.tags.update', 'method'=>'put', 'class'=>'js-tags-form', 'files'=>TRUE)) }}
<div class="left-title">Теги</div>
<table class="dashboard__form-table form-tags js-tags-cont">
@foreach($tags as $tag)
    @include(Helper::acclayout('assets.brand-tag-tr'),compact('tag'))
@endforeach
</table>
<table class="dashboard__form-table">
    <tr class="tags__item js-tags-item js-tag-sample" style="display: none;">
        <td class="form-table__name">
            <input class="name__input js-tags-input" type="file" name="tag_photos[]">
            <div class="name__hover">
                <span class="js-tags-filename">Загрузить<br>изображение</span>
            </div>
        </td>
        <td class="form-table__value">
            <input name="tags[]" class="dashboard-input" placeholder="Имя тега">
            <a href="#" data-action="{{ URL::route('brand.tags.delete') }}" class="value__delete js-tag-delete"></a>
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
