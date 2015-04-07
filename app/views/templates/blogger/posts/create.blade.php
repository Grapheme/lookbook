<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
reset($categories);
$selectedCategory = key($categories);
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
                    <div class="reg-content__left">
                        {{ Form::open(array('route'=>'posts.store','method'=>'post','class'=>'newpost-form js-ajax-form')) }}
                            <div>
                                <span>Дата</span>
                                {{ Form::text('publish_at',date('d.m.Y'),array()) }}
                            </div>
                            <div>
                                <span>Выберите категорию</span>
                                {{ Form::select('category_id',$categories,NULL,array('autocomplete'=>'off')) }}
                            </div>
                            <div>
                                <span>Теги</span>
                                <select name="tags[]" autocomplete="off" multiple>
                            @foreach($tags as $category_id => $categories_tags)
                                @foreach($categories_tags['category_tags'] as $tag_id => $tag_title)
                                    <option {{ $selectedCategory == $category_id ? '' : 'style="display: none;"' }} data-category="{{ $category_id }}" value="{{ $tag_id }}">{{ $tag_title }}</option>
                                @endforeach
                            @endforeach
                                </select>
                            </div>
                            <div>
                                <span>Название</span>
                                {{ Form::text('title',NULL,array()) }}
                            </div>
                            <div>
                                <span>Текст публикации</span>
                                {{ Form::textarea('content',NULL,array('class'=>'redactor')) }}
                            </div>
                            <div>
                                <span>Изображение</span>
                                <label class="input">
                                    {{ ExtForm::image('photo_id',NULL) }}
                                </label>
                            </div>
                            <div>
                                <span>Подпись к изображаению</span>
                                {{ Form::text('photo_title',NULL,array()) }}
                            </div>
                            <div>
                                <span>Галерея</span>
                                <label class="input">
                                    {{ ExtForm::gallery('gallery',NULL) }}
                                </label>
                            </div>
                            <div>
                                {{ Form::button('Просмотр',array('class'=>'blue-hover us-btn btn-preview','data-url'=>URL::route('post.preview'))) }}
                                {{ Form::submit('На модерацию',array('class'=>'blue-hover us-btn')) }}
                            </div>
                            <p class="js-response-text"></p>
                       {{ Form::close() }}
                    </div>
                    <div class="reg-content__right"></div>
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