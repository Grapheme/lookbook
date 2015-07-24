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
                            <a href="{{ URL::route('moderator.promo.create') }}" class="white-btn">Новый баннер</a>
                        </div>
                        <div class="left-title">Первая 10</div>
                        @include(Helper::acclayout('assets.posts-promo-table'),array('posts'=>$posts,'position'=>0))
                        <div class="left-title">Вторая 10</div>
                        @include(Helper::acclayout('assets.posts-promo-table'),array('posts'=>$posts,'position'=>1))
                        <div class="left-title">Третья 10</div>
                        @include(Helper::acclayout('assets.posts-promo-table'),array('posts'=>$posts,'position'=>2))
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