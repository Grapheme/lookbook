<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::acclayout())
@section('style')
    {{ HTML::stylemod(Config::get('site.theme_path').'/styles/dropzone.css') }}
    {{ HTML::stylemod(Config::get('site.theme_path').'/styles/messagebox.css') }}
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
                        <div class="form__title">Новый баннер</div>
                        {{ Form::open(array('route'=>'moderator.promo.store','class'=>'newpost-form js-ajax-form')) }}
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Дата начала публикации</div>
                                {{ Form::text('start_date',NULL,array('class'=>'us-input js-datepicker')) }}
                            </div>
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Дата окончания публикации</div>
                                {{ Form::text('stop_date',NULL,array('class'=>'us-input js-datepicker')) }}
                            </div>
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Выберите позицию</div>
                                {{ Form::select('position',array('4'=>'4 место', '8'=>'8 место', '14'=>'14 место', '18'=>'18 место'),NULL,array('class'=>'js-styled-select')) }}
                            </div>
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Порядковый номер</div>
                                {{ Form::text('order',NULL,array('class' => 'us-input', 'style' => 'width: 70px;')) }}
                            </div>
                            <div class="clearfix"></div>
                            <div class="form__input-block">
                                <div class="form__input-title">Ссылка</div>
                                {{ Form::text('link',NULL,array('class' => 'us-input')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Изображение</div>
                                <label class="input">
                                    {{ ExtForm::image('photo_id') }}
                                </label>
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Код видео</div>
                                {{ Form::textarea('video',NULL,array('class'=>'us-textarea js-autosize')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Места размещения</div>
                                <div class="section__content">
                                    <div class="check-cont js-set-check">
                                        {{ Form::checkbox('in_index',1,NULL,array('class'=>'js-styled-check')) }}
                                        <label>На главной</label>
                                    </div>
                                    <div class="check-cont js-set-check">
                                        {{ Form::checkbox('in_section',1,NULL,array('class'=>'js-styled-check')) }}
                                        <label>В разделе</label>
                                    </div>
                                    <div class="check-cont js-set-check">
                                        {{ Form::checkbox('in_line',1,NULL,array('class'=>'js-styled-check')) }}
                                        <label>В ленте</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form__btns">
                                {{ Form::button('Опубликовать',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
                            </div>
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
@stop