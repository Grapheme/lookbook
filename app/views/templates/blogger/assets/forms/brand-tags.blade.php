<div class="left-title">Теги</div>
<table class="dashboard__form-table form-tags js-tags-cont">
@foreach($tags as $tag)
    @include(Helper::acclayout('assets.brand-tag-tr'),compact('tag'))
@endforeach
</table>
<table class="dashboard__form-table">
    <tr class="tags__item js-tags-item js-tag-sample" style="display: none;">
        <td class="form-table__name js-select-tag-image">
            <div class="name__hover">
                <span class="js-tags-filename">Загрузить<br>изображение</span>
            </div>
        </td>
        <td class="form-table__value">
            {{ Form::open(array('route'=>'brand.tags.update', 'method'=>'put', 'class'=>'js-tags-form', 'files'=>TRUE)) }}
            <input class="name__input js-tags-input" type="file" name="tag_photo" style="display: none;">
            <input name="tag_title" class="dashboard-input" placeholder="Имя тега">
            {{ Form::button('OK',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
            <a href="#" data-action="{{ URL::route('brand.tags.delete') }}" class="value__delete js-tag-delete"></a>
            {{ Form::close() }}
        </td>
    </tr>
    <tr class="tags__add">
        <td class="form-table__name" colspan="2">
            <a href="#" class="us-link js-add-tag">Добавить</a>
        </td>
    </tr>
</table>
