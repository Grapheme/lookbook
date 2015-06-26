<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::acclayout())
@section('style')
    {{ HTML::stylemod(Config::get('site.theme_path').'/styles/dropzone.css') }}
    {{ HTML::stylemod(Config::get('site.theme_path').'/styles/messagebox.css') }}
    {{ HTML::style('private/css/redactor.css') }}
    <script>
        var base_url = '{{ URL::to('') }}';
    </script>
@stop
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                @include(Helper::acclayout('assets.user_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left new-post-form">
                        <div class="form__title">Новый пост</div>
                        {{ Form::model($post,array('route'=>array('posts.update',$post->id),'method'=>'put','class'=>'newpost-form js-ajax-form')) }}
                            {{ Form::hidden('publish_at',(new myDateTime())->setDateString($post->publish_at)->format('d.m.Y'),array()) }}
                            <div class="form__date">
                                {{-- Form::text('publish_at',(new myDateTime())->setDateString($post->publish_at)->format('d.m.Y'),array('disabled' => 'disabled', 'class' => 'js-datepicker')) --}}
                                <p>{{(new myDateTime())->setDateString($post->publish_at)->format('d.m.Y')}}</p>
                                <!-- <a href="#">Изменить</a> -->
                            </div>
                            <div class="form__top">
                                <div class="clearfix">
                                    <div class="top__select-block form__input-block">
                                        <div class="form__input-title">Выберите категорию</div>
                                        {{ Form::select('category_id',$categories,$post->category_id,array('autocomplete'=>'off', 'class'=>'us-select js-styled-select')) }}
                                    </div>
                                    <div style="display: none;" class="top__select-block form__input-block">
                                        <div class="form__input-title">Теги</div>
                                        <select class="us-mselect" name="tags[]" autocomplete="off" multiple>
                                    @foreach($tags as $category_id => $categories_tags)
                                        @foreach($categories_tags['category_tags'] as $tag_id => $tag_title)
                                            <option {{ $post->category_id == $category_id ? '' : 'style="display: none;"' }} {{ !empty( $post->tags) && $post->category_id == $category_id && array_key_exists($tag_id,$post->tags) ? 'selected="selected"' : '' }} data-category="{{ $category_id }}" value="{{ $tag_id }}">{{ $tag_title }}</option>
                                        @endforeach
                                    @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form__input-block">
                                    <div class="form__input-title">Название</div>
                                    {{ Form::text('title',NULL,array('class' => 'us-input')) }}
                                </div>
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Изображение</div>
                                <label class="input">
                                    {{ ExtForm::image('photo_id') }}
                                </label>
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Подпись к изображаению</div>
                                {{ Form::text('photo_title',NULL,array('class'=>'us-input')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Текст, изображение, видео поста</div>
                                {{ Form::textarea('content',NULL,array('class'=>'redactor')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Галерея</div>
                                <label class="input">
                                    {{ ExtForm::gallery('gallery',is_object($post->gallery) ? $post->gallery->id : NULL) }}
                                </label>
                            </div>
                            <div class="form__btns">
                                {{ Form::button('Просмотр',array('class'=>'blue-hover us-btn btn-preview gray-btn','data-url'=>URL::route('post.preview'))) }}
                                {{ Form::button('Опубликовать',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
                            </div>
                            <button id="auto-save" data-url="{{ URL::route('post.auto.save',$post->id) }}" style="display: none"></button>
                            <p class="js-response-text"></p>
                       {{ Form::close() }}
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop
@section('scripts')
    {{ HTML::script('private/js/vendor/SmartNotification.min.js') }}
    {{ HTML::script('private/js/system/messages.js') }}
    {{ HTML::script('private/js/system/main.js') }}
    {{ HTML::script("private/js/vendor/dropzone.min.js") }}
    {{ HTML::scriptmod(Config::get('site.theme_path')."/scripts/gallery.js") }}
    {{ HTML::scriptmod(Config::get('site.theme_path')."/scripts/app.js") }}

    {{ HTML::script('private/js/vendor/redactor.min.js') }}
    {{ HTML::script('private/js/system/redactor-config.js') }}
@stop