<?
/*
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
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
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">

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