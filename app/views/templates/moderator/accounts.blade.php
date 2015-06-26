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
                    <div class="req-content__full border-none">
                        <div class="left-title">Статистика</div>
                        <div class="full__content">
                            <p>Всего пользователей: {{ User::where('group_id',4)->count() }}</p>
                            <p>Забаненых: {{ User::where('group_id',4)->where('active',0)->count() }}</p>
                            <p>Брендов: {{ User::where('group_id',4)->where('brand',1)->count() }}</p>
                            <p>Забаненых брендов: {{ User::where('group_id',4)->where('brand',1)->where('active',0)->count() }}</p>
                        </div>
                        @if($accounts->count())
                            @include(Helper::acclayout('assets.accounts-table'),compact('accounts'))
                            {{ $accounts->links() }}
                        @else
                            <p>Нет зарегистрированных пользователей</p>
                        @endif
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