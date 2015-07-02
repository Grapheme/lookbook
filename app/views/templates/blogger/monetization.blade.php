<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::acclayout())
@section('style')
    {{ HTML::style('private/css/redactor.css') }}
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
                        @include(Helper::acclayout('assets.forms.blogger_monetization'))
                    </div>
                    <div class="reg-content__right">
                        @include(Helper::acclayout('assets.recommended-list'))
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="ava-overlay js-ava-overlay">
        <div class="overlay__background"></div>
        <div class="overlay__content">
            <div class="left-title">Выберите область изображения<a href="#" class="overlay__close js-ava-overlay-close">✕</a></div>
            <div class="overlay__image js-crop-ava"></div>
            <div class="overlay__preview preview-huge js-crop-preview"></div>
            <div class="overlay__btns">
                {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','id'=>'ava-crop-upload')) }}
                <input name="photo" type="hidden">
                <div class="btns__error js-response-text"></div>
                <a href="#" class="us-btn gray-btn js-ava-overlay-close">Отменить</a>
                <button type="submit" class="us-btn blue-hover">Сохранить</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
@section('scripts')
    {{ HTML::script('private/js/vendor/redactor.min.js') }}
    {{ HTML::script('private/js/system/redactor-config.js') }}
@stop