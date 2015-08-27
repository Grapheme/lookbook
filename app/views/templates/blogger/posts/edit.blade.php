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
                        {{ Form::model($post,array('route'=>array('posts.update',$post->id),'method'=>'put','class'=>'newpost-form js-ajax-form-gallery')) }}
                            {{ Form::hidden('publish_at',(new myDateTime())->setDateString($post->publish_at)->format('d.m.Y'),array()) }}
                            <div class="form__date">
                                <p>{{(new myDateTime())->setDateString($post->publish_at)->format('d.m.Y')}}</p>
                            </div>
                            <div class="form__top">
                                <div class="clearfix">
                                    <div class="top__select-block form__input-block">
                                        <div class="form__input-title">Выберите категорию <a href="{{ pageurl('pomosch-na-kakie-temy-stoit-vesti-blog-na-lookbook') }}" target="_blank" class="sub-link">Подробнее</a></div>
                                        {{ Form::select('category_id',$categories,$post->category_id,array('autocomplete'=>'off', 'class'=>'us-select js-styled-select js-cat-select')) }}
                                    </div>
                                @if(Auth::user()->brand && $tags = BrandTags::where('user_id', Auth::user()->id)->orderBy('title')->lists('title','id'))
                                    <div class="top__select-block form__input-block">
                                        <div class="form__input-title">Теги</div>
                                        {{ Form::select('tags[]', $tags, $post->tags_ids->lists('tag_id'), array('data-placeholder'=>'Выберите теги', 'class'=>'us-mselect js-cat-tags', 'autocomplete'=>'off', 'multiple'=>'')) }}
                                    </div>
                                @endif
                                </div>
                                <div class="form__input-block">
                                    <div class="form__input-title">Название</div>
                                    {{ Form::text('title',NULL,array('class' => 'us-input', 'placeholder' => '')) }}
                                </div>
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Главное изображение</div>
                                <label class="input">
                                    {{ ExtForm::image('photo_id') }}
                                </label>
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Подпись к изображению</div>
                                {{ Form::text('photo_title',NULL,array('class'=>'us-input')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Текст, изображение, видео</div>
                                {{ Form::textarea('content',NULL,array('class'=>'redactor')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Галерея</div>
                                <label class="input js-gallery-extform">
                                    {{ ExtForm::gallery('gallery',is_object($post->gallery) ? $post->gallery->id : NULL) }}
                                </label>
                            </div>
                            <div class="form__btns">
                                {{ Form::button('Посмотреть',array('class'=>'blue-hover us-btn btn-preview gray-btn','data-url'=>URL::route('post.preview'))) }}
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

    <script>
        var saveCaption = function($this, callback) {
            var image_id = $this.attr('data-photo-id');
            var image_title = $this.parents('.image-data').find('.image-data-field[data-name=title]').val();
            var popover = $this.parents('.popover');
            var popover_link = $(popover).prev('a.image-data-popover');
            var popover_error = $(popover).find('.image-save-data-error');
            $(popover_link).attr('data-image-title', image_title);

            $this.removeClass('btn-danger').addClass('btn-primary');
            $(popover_error).text('');

            $this.addClass('loading').attr('disabled', 'disabled');
            $.ajax({
                url: base_url + "/admin/galleries/photoupdate",
                data: { id: image_id, title: image_title },
                type: 'post'
            }).done(function(){
                if(callback) callback();
                return true;
            }).fail(function(data){
                console.log(data);
                $(popover_error).text('Ошибка при сохранении');
                $this.removeClass('btn-primary').addClass('btn-danger');
                return false;
            }).always(function(){
                $this.removeClass('loading').removeAttr('disabled');
            });
        }

        $(function(){
            $('.image-data-popover').each(function(){
                $(this).after($(this).attr('data-content'));
                $(this).next().find('textarea').val($(this).attr('data-image-title'));
            });
        });

        $(document).on('click', '.image-data-popover', function(event) {
            var popover = $(this).next('.popover');
            var current_title = $(this).attr('data-image-title');
            $(popover).find('.image-data-field[data-name=title]').val(current_title);
        });

        $(document).on('click', '.image-data-preview-link', function(e){
            var popover = $(this).parents('.popover');
            $(popover).fadeOut();
        });

        $(document).on('click', '.save-image-data', function(event){
            event.preventDefault();
            saveCaption($(this));
        });

        $('.js-ajax-form-gallery').on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            $this.find('[type="submit"]').addClass('loading');
            var saveCaptionEq = function(eq) {
                saveCaption($('.save-image-data').eq(eq), function(){
                    if($('.save-image-data').eq(eq+1).length) {
                        saveCaptionEq(eq+1);
                    } else {
                        Help.ajaxSubmit($this);
                    }
                });
            }
            saveCaptionEq(0);
        });

    </script>
@stop