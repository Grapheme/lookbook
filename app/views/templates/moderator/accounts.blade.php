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
                    @if($accounts->count())
                        @include(Helper::acclayout('assets.accounts-table'),compact('accounts'))
                        {{ $accounts->links() }}
                    @else
                        <p>Нет зарегистрированных пользователей</p>
                    @endif
                    </div>
                    <div class="reg-content__right">
                        <div class="right-title">Статистика</div>
                        <div class="right-content">Всего пользователей: {{ User::where('group_id',4)->count() }}</div>
                        <div class="right-content">Забаненых: {{ User::where('group_id',4)->where('active',0)->count() }}</div>
                        <div class="right-content">Брендов: {{ User::where('group_id',4)->where('brand',1)->count() }}</div>
                        <div class="right-content">Забаненых брендов: {{ User::where('group_id',4)->where('brand',1)->where('active',0)->count() }}</div>
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