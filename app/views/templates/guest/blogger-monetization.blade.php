<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>

@section('title'){{ $user->name }}@stop
@section('description')@stop
@section('keywords')@stop

@extends(Helper::layout())
@section('style')
@stop
@section('page_class')
@stop
@section('content')
<header>
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                @include(Helper::layout('assets.blogger_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content monetization">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <div class="left-title">Монетизация</div>
                        <div class="form-desc money-block">
                            <div class="block__section">
                                <div class="section__desc">
                                    <p>Интересующие варианты сотрудничества:</p>
                                </div>
                                <div class="section__content">
                                    <ul>
                                        <li> Сотрудничество на платной основе
                                    </ul>
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
                        <div class="left-content">
                    @foreach(Dic::where('slug','cooperation_brands')->first()->values as $cooperation)
                        @if(in_array($cooperation->id, $monetization['cooperation']))
                            {{ $cooperation->name }}
                        @endif
                    @endforeach
                        </div>
                    </div>
                    <div class="reg-content__right">

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</header>
@stop
@section('scripts')
@stop