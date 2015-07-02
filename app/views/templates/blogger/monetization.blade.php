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
                        <div class="left-title">Монетизация</div>
                        <div class="form-desc money-block">
                            <div class="block__section">
                                <div class="section__desc">
                                    <p>Интересующие типы сотрудничества:</p>
                                </div>
                                <div class="section__content">
                                    <ul>
                                        <li> Сотрудничество на платной основе
                                    </ul>
                                </div>
                            </div>
                            <div class="block__section">
                                <div class="section__desc">Отличительные особенности блога:</div>
                                <div class="section__content">
                                    Мой блог повествует о загадочной жизни Европейских звезд
                                </div>
                            </div>
                            <div class="block__section">
                                <div class="section__desc">Основная направленность:</div>
                                <div class="section__content">
                                    <ul>
                                        <li> Fashion
                                        <li> Beauty
                                    </ul>
                                </div>
                            </div>
                            <div class="block__section">
                                <div class="section__desc">
                                    Контакты по вопросам сотрудничества:
                                </div>
                            </div>
                            <table class="dashboard__form-table">
                                <tr>
                                    <td class="form-table__name">Телефон</td>
                                    <td class="form-table__value">
                                        +79518330422
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <table class="dashboard__form-table">
                            <tr class="form-table__btns">
                                <td class="form-table__name"></td>
                                <td class="form-table__value">
                                    {{ Form::button('Сохранить',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
                                    <div class="response-text js-response-text"></div>
                                </td>
                            </tr>
                        </table>
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