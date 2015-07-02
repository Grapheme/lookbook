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
                    <div class="req-content__full">
                        <div class="promo-btn">
                            <a href="#" class="white-btn">Новый баннер</a>
                        </div>
                        <div class="left-title">Первая 10</div>
                            <table class="moder-table">
                                <thead>
                                <th class="table__number">№<!--  п.п --></th>
                                <th>Информация</th>
                                <th></th>
                                </thead>
                                <tbody>
                                    <tr class="js-post">
                                        <td class="table__number">1</td>
                                        <td class="table__promo">
                                            <div class="promo__image">
                                                <a href="#" class="image__link" style="background-image: url(http://dummyimage.com/600x400/000/fff&text=TEST);"></a>
                                            </div>
                                            <div class="promo__info">
                                                <div class="info__link">
                                                    <a href="#">http://link-to-promo.com</a>
                                                </div>
                                                <div class="info__date">
                                                    02.07.2015 - 10.07.2015
                                                </div>
                                            </div>
                                        </td>
                                        <td class="table__actions js-slide-parent">
                                            <a href="#" class="white-btn">Редактировать</a>
                                            <form class="js-delete-post" style="margin-top: 10px">
                                                <button class="white-btn action-delete" type="submit"><i class="svg-icon icon-cross"></i>Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <div class="left-title">Вторая 10</div>
                        <div class="left-title">Третья 10</div>
                        @if($posts->count())
                            @include(Helper::acclayout('assets.posts-promo-table'),compact('posts'))
                            {{ $posts->links() }}
                        @else
                            <p>Промо посты отсутствуют</p>
                        @endif
                    </div>
                    <div class="clearfix"></div>


                    <!-- ФОРМА СОЗДАНИЯ/РЕДАКТИРОВАНИЯ БАННЕРА -->


                    <div class="reg-content__left new-post-form">
                        <div class="form__title">Новый баннер</div>
                        <form class="newpost-form js-ajax-form">
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Дата начала публикации</div>
                                <input class="us-input js-datepicker">
                            </div>
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Дата окончания публикации</div>
                                <input class="us-input js-datepicker">
                            </div>
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Выберите позицию</div>
                                <select class="js-styled-select">
                                    <option>Первая 10</option>
                                    <option>Вторая 10</option>
                                    <option>Третья 10</option>
                                </select>
                            </div>
                            <div class="top__select-block form__input-block">
                                <div class="form__input-title">Порядковый номер</div>
                                {{ Form::text('title',NULL,array('class' => 'us-input', 'style' => 'width: 70px;')) }}
                            </div>
                            <div class="clearfix"></div>
                            <div class="form__input-block">
                                <div class="form__input-title">Ссылка</div>
                                {{ Form::text('title',NULL,array('class' => 'us-input')) }}
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Изображение</div>
                                <label class="input">
                                    {{ ExtForm::image('photo_id') }}
                                </label>
                            </div>
                            <div class="form__input-block">
                                <div class="form__input-title">Код видео</div>
                                {{ Form::textarea('content',NULL,array('class'=>'us-textarea js-autosize')) }}
                            </div>
                            <div class="form__btns">
                                {{ Form::button('Опубликовать',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
                            </div>
                            <p class="js-response-text"></p>
                        </form>
                    </div>
                    <div class="clearfix"></div>


                    <!-- /КОНЕЦ/ ФОРМА СОЗДАНИЯ/РЕДАКТИРОВАНИЯ БАННЕРА -->


                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop
@section('scripts')

@stop