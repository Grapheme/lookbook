<tr class="tags__item js-tags-item">
    <td class="form-table__name js-select-tag-image">
        <div class="name__hover">
            <span>Загрузить<br>изображение</span>
        </div>
        @if(!empty($tag->photo) && File::exists(Config::get('site.galleries_photo_dir') . '/' . $tag->photo->name))
            <div class="name__image js-tags-image"
                 style="background-image: url({{ asset(Config::get('site.galleries_photo_public_dir').'/'.$tag->photo->name) }})"></div>
        @endif
    </td>
    <td class="form-table__value">
        {{ Form::open(array('route'=>'brand.tags.update', 'method'=>'put', 'class'=>'js-tags-form', 'files'=>TRUE)) }}
        <input type="hidden" name="tag_id" value="{{ $tag->id }}">
        <input class="name__input" type="file" name="tag_photo"  style="display: none;">
        <input name="tag_title" class="dashboard-input" value="{{ $tag->title }}" placeholder="Имя тега">
        {{ Form::button('OK',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
        <a href="#" data-action="{{ URL::route('brand.tags.delete') }}" data-tag-id="{{ $tag->id }}" class="value__delete js-tag-delete"></a>
        {{ Form::close() }}
    </td>
</tr>