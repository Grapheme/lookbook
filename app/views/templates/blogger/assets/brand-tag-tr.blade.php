{{ Form::hidden('tag_id[]', $tag->id) }}
<tr class="tags__item js-tags-item">
    <td class="form-table__name">
        <input class="name__input" type="file" name="tag_photos[]">
        <div class="name__hover">
            <span>Загрузить<br>изображение</span>
        </div>
        @if(!empty($tag->photo) && File::exists(Config::get('site.galleries_photo_dir') . '/' . $tag->photo->name))
            <div class="name__image js-tags-image"
                 style="background-image: url({{ asset(Config::get('site.galleries_photo_public_dir').'/'.$tag->photo->name) }})"></div>
        @endif
    </td>
    <td class="form-table__value">
        <input name="tags[]" class="dashboard-input" value="{{ $tag->title }}" placeholder="Имя тега">
        <a href="#" data-action="{{ URL::route('brand.tags.delete') }}" data-tag-id="{{ $tag->id }}" class="value__delete js-tag-delete"></a>
    </td>
</tr>