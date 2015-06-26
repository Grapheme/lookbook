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

                    </div>
                    <div class="reg-content__right">
                        <div class="right-title">Статистика</div>
                        <div class="right-content">
                            <p>Всего постов: {{ Post::where('publication',1)->count() }}</p>
                            <p>Всего пользователей: {{ User::where('group_id',4)->count() }}</p>
                            <p>Всего брендов: {{ User::where('group_id',4)->where('brand',1)->count() }}</p>
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