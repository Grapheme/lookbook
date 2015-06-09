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
                        <div class="left-title big-title">Мой блог-лист</div>
                    @if(count($blogs))
                        <ul class="blog-list js-posts">
                            @include(Helper::layout('blocks.subscribes.blogs'),compact('blogs'))
                        </ul>
                        @if($blogs_total_count > count($blogs))
                            @include(Helper::layout('assets.more_blogs'),array('user'=>Auth::user()->id,'blogs_limit'=>Config::get('lookbook.blogs_limit')))
                        @endif
                    @else
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__desc">
                                Блог лист пуст.
                            </div>
                        </div>
                    @endif
                    </div>
                    <div class="reg-content__right">
                        @include(Helper::acclayout('assets.recommended-list'),compact('recommended_blogs'))
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