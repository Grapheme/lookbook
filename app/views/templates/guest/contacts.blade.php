<?
/**
 * TITLE: Контакты
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())
@section('style')
@stop
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                <div class="category-header header-lite">
                    <div class="header__title">{{ $page->seo->h1 }}</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content border-none">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <div class="contact-us">
                            <div class="us__desc">Если у вас есть вопросы или предложения, заполните и отправьте форму:
                            </div>
                            {{ Form::open(array('url'=>URL::route('contacts-send-question'),'class'=>'js-contact-form')) }}
                                <table class="us__table">
                                    <tr>
                                        <td>Представтесь</td>
                                        <td>
                                            {{ Form::text('name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Электронная почта</td>
                                        <td>
                                            {{ Form::email('email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Тема</td>
                                        <td>
                                            <select name="theme" class="us-select js-styled-select">
                                                <option value="Служба технической поддержки">Служба технической поддержки</option>
                                                <option value="Для прессы">Для прессы</option>
                                                <option value="Реклама на сайте">Реклама на сайте</option>
                                                <option value="Другое">Другое</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Текст сообщения</td>
                                        <td>
                                            {{ Form::textarea('message') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ Form::button('Отправить',array('type'=>'submit','class'=>'us-btn blue-hover')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="js-response-text"></td>
                                    </tr>
                                </table>
                            {{ Form::close() }}
                            <div class="us__success js-contact-success">Ваше сообщение успешно отправленно!</div>
                        </div>
                    </div>
                    <div class="reg-content__right right-links">
                        <div class="right-title">
                            <a href="{{ pageurl('about') }}">О проекте</a>
                        </div>
                        <div class="right-title">
                            <a href="{{ pageurl('help') }}">Помощь</a>
                        </div>
                        <div class="right-title">
                            <a href="{{ pageurl('contacts') }}" class="active">Связаться с нами</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop
@section('scripts')
@stop