<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::acclayout())
@section('style')
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
                        {{ Form::model($profile,array('route'=>'profile.update','method'=>'put','id'=>'dashboard-main', 'class'=>'js-dashboard-form','files'=>TRUE)) }}
                            <div class="left-title">Основное</div>
                            <table class="dashboard__form-table">
                                <tr>
                                    <td class="form-table__name"><span>Имя</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('name',Input::old('name'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Дата рождения</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('birth',Input::old('birth'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Местонахождение</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('location',Input::old('location'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Мои блоги на сторонних ресурсах</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('links',Input::old('links'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Мой сайт</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('site',Input::old('site'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Источники вдохновения</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('inspiration',Input::old('inspiration'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                            </table>
                            <div class="left-title">Для связи со мной</div>
                            <table class="dashboard__form-table">
                                <tr>
                                    <td class="form-table__name"><span>Электронная почта</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('email',Input::old('email'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Телефон</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('phone',Input::old('phone'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                            </table>
                            <div class="left-title">О блоге</div>
                            <table class="dashboard__form-table">
                                <tr>
                                    <td class="form-table__name"><span>Название блога</span></td>
                                    <td class="form-table__value js-form-value">
                                        <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                                        <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                                        {{ Form::text('blogname',Input::old('blogname'),array('class'=>'dashboard-input')) }}
                                    </td>
                                </tr>
                                @if($profile->brand)
                                <tr>
                                    <td class="form-table__name"><span>Имеджевая картинка для блога</span></td>
                                    <td class="form-table__value form-table__file js-form-file">
                                        <a href="#" class="input-file-value"><span>Выбрать</span></a>
                                        {{ Form::file('picture',array('class'=>'dashboard-input-file')) }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="form-table__name"><span>Текст о себе или о блоге</span></td>
                                    <td class="form-table__value form-table__texarea-cont">
                                        {{ Form::textarea('about',Input::old('about'),array('class'=>'dashboard-textarea js-autosize')) }}
                                    </td>
                                </tr>
                                <tr class="form-table__btns">
                                    <td class="form-table__name"></td>
                                    <td class="form-table__value">
                                        {{ Form::submit('Сохранить',array('class'=>'blue-hover us-btn')) }}
                                        <div class="response-text js-response-text"></div>
                                    </td>
                                </tr>
                            </table>
                        {{ Form::close() }}
                        {{ Form::open(array('route'=>'profile.password.update','method'=>'put','id'=>'dashboard-pass','class'=>'js-dashboard-form')) }}
                            <div class="left-title">Пароль и защита данных</div>
                            <table class="dashboard__form-table">
                                <tr>
                                    <td class="form-table__name"><span>Пароль</span></td>
                                    <td class="form-table__value">
                                        <input name="password" value="" placeholder="********" type="password"
                                               class="dashboard-input">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-table__name"><span>Подтверждение пароля</span></td>
                                    <td class="form-table__value">
                                        <input name="password_confirmation" value="" placeholder="********"
                                               type="password" class="dashboard-input">
                                    </td>
                                </tr>
                                <tr class="form-table__btns">
                                    <td class="form-table__name"></td>
                                    <td class="form-table__value">
                                        <button type="submit" class="blue-hover us-btn">Сохранить</button>
                                        <div class="response-text js-response-text"></div>
                                        <!--button(type="submit").blue-hover.us-btn Отменить-->
                                    </td>
                                </tr>
                            </table>
                        {{ Form::close() }}
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
                                    {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','id'=>'ava-change','class'=>'ava-image__cont')) }}
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
                                    {{ Form::open(array('route'=>'profile.avatar.delete','method'=>'delete','id'=>'ava-delete','class'=>'ava-delete-form')) }}
                                        <a href="javascript:void(0);" class="ava-delete js-submit"><i class="icon-cross37 svg-icon"></i></a>
                                    {{ Form::close() }}
                                    {{ Form::open(array('route'=>'profile.avatar.upload','method'=>'post','id'=>'ava-upload','class'=>'ava-upload-form')) }}
                                        <a href="javascript:void(0);" class="ava-upload js-submit"><span>Загрузить аватарку</span>
                                            {{ Form::file('photo',array('class'=>'js-ava-input')) }}
                                        </a>
                                    {{ Form::close() }}
                                    <div id="ava-error-cont" class="ava-error"></div>
                                    <div id="ava-error-server" class="ava-error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="right-title">Статистика</div>
                        <div class="right-content">
                            <table class="stat-table">
                                <tr>
                                    <td>Рейтинг</td>
                                    <td>132 место из 2356</td>
                                </tr>
                                <tr>
                                    <td>Записей в блоге</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>Комментариев опубликовано</td>
                                    <td>42</td>
                                </tr>
                                <tr>
                                    <td>Количество подписчиков</td>
                                    <td>10444</td>
                                </tr>
                                <tr>
                                    <td>Количество посетителей в день</td>
                                    <td>31233</td>
                                </tr>
                                <tr>
                                    <td>Количество посетителей с февраля</td>
                                    <td>233</td>
                                </tr>
                                <tr>
                                    <td>Количество посетителей в год</td>
                                    <td>1232032</td>
                                </tr>
                            </table>
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