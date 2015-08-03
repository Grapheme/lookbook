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
                    @if(Auth::user()->brand)
                        @include(Helper::acclayout('assets.forms.brand-profile'))
                    @else
                        @include(Helper::acclayout('assets.forms.blogger-profile'))
                    @endif
                        @include(Helper::acclayout('assets.forms.password-update'))
                    </div>
                    <div class="reg-content__right">
                        <div class="right-title">Аватарка</div>
                        <div class="right-content">
                        <?php
                            $hasImage = FALSE;
                            if(!empty(Auth::user()->photo) && File::exists(public_path($profile->photo))):
                                $hasImage = TRUE;
                            endif;
                        ?>
                            <div data-empty-name="{{ $profile->name }} {{ $profile->surname }}" class="ava-change{{ !$hasImage ? ' ava-empty ' : ' ' }}js-ava-cont">
                                <div class="ava-image">
                                    {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','class'=>'ava-image__cont js-ava-change-form', 'data-ratio'=>'1', 'data-minHeight'=>'50', 'data-minWidth'=>'50', 'data-type'=>'ava')) }}
                                        <a href="javascript:void(0);" class="ava-change js-submit">Изменить</a>
                                        {{ Form::file('photo',array('class'=>'js-ava-input')) }}
                                    {{ Form::close() }}
                                    <div class="js-ava-img-cont">
                                    @if($hasImage)
                                        <img src="{{ asset($profile->photo) }}">
                                    @endif
                                    </div>
                                    <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
                                </div>
                                <div class="ava-links">
                                    {{ Form::open(array('route'=>'profile.avatar.delete','method'=>'delete','class'=>'js-ava-delete ava-delete-form')) }}
                                        <a href="javascript:void(0);" class="ava-delete js-submit"><i class="icon-cross37 svg-icon"></i></a>
                                    {{ Form::close() }}
                                    {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post', 'class'=>'ava-upload-form js-ava-upload-form', 'data-ratio'=>'1', 'data-minHeight'=>'50', 'data-minWidth'=>'50', 'data-type'=>'ava')) }}
                                        <a href="javascript:void(0);" class="ava-upload js-submit"><span>Загрузить аватарку</span>
                                            {{ Form::file('photo',array('class'=>'js-ava-input')) }}
                                        </a>
                                    {{ Form::close() }}
                                    <div class="js-ava-error-cont ava-error"></div>
                                    <div class="js-ava-error-server ava-error"></div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->brand)
                        <div class="right-title">Фоновое изображение</div>
                        <div class="right-content">
                            <div data-empty-name="" class="ava-background ava-change{{ !$hasImage ? ' ava-empty ' : ' ' }}js-ava-cont">
                                <div class="ava-image">
                                    {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','class'=>'ava-image__cont js-ava-change-form', 'data-ratio'=>'2.28', 'data-minHeight'=>'300', 'data-minWidth'=>'500', 'data-type'=>'background')) }}
                                        <a href="javascript:void(0);" class="ava-change js-submit">Изменить</a>
                                        {{ Form::file('photo',array('class'=>'js-ava-input')) }}
                                    {{ Form::close() }}
                                    <div class="js-ava-img-cont">
                                    @if($hasImage)
                                        <img src="{{ asset($profile->photo) }}">
                                    @endif
                                    </div>
                                    <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
                                </div>
                                <div class="ava-links">
                                    {{ Form::open(array('route'=>'profile.avatar.delete','method'=>'delete','class'=>'js-ava-delete ava-delete-form')) }}
                                        <a href="javascript:void(0);" class="ava-delete js-submit"><i class="icon-cross37 svg-icon"></i></a>
                                    {{ Form::close() }}
                                    {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','class'=>'ava-upload-form js-ava-upload-form', 'data-ratio'=>'2.28', 'data-minHeight'=>'300', 'data-minWidth'=>'500', 'data-type'=>'background')) }}
                                        <a href="javascript:void(0);" class="ava-upload js-submit"><span>Загрузить изображение</span>
                                            {{ Form::file('photo',array('class'=>'js-ava-input')) }}
                                        </a>
                                    {{ Form::close() }}
                                    <div class="js-ava-error-cont ava-error"></div>
                                    <div class="js-ava-error-server ava-error"></div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @include(Helper::acclayout('assets.statistic'))
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="ava-overlay js-ava-overlay" data-type="ava">
        <div class="overlay__background"></div>
        <div class="overlay__content">
            <div class="left-title">Выберите область изображения<a href="#" class="overlay__close js-ava-overlay-close">✕</a></div>
            <div class="overlay__image js-crop-ava"></div>
            <div class="overlay__preview preview-huge js-crop-preview"></div>
            <div class="overlay__btns">
                {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','class'=>'js-ava-crop-upload')) }}
                <input name="photo" type="hidden">
                <div class="btns__error js-response-text"></div>
                <a href="#" class="us-btn gray-btn js-ava-overlay-close">Отменить</a>
                <button type="submit" class="us-btn blue-hover">Сохранить</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="ava-overlay ava-background js-ava-overlay" data-type="background">
        <div class="overlay__background"></div>
        <div class="overlay__content">
            <div class="left-title">Выберите область изображения<a href="#" class="overlay__close js-ava-overlay-close">✕</a></div>
            <div class="overlay__image js-crop-ava"></div>
            <div class="overlay__preview preview-huge js-crop-preview"></div>
            <div class="overlay__btns">
                {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','class'=>'js-ava-crop-upload')) }}
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