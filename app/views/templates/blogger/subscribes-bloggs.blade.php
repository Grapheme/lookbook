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
                    @if(count($posts))
                        <ul class="dashboard-list js-posts">
                            @include(Helper::layout('blocks.posts'),compact('posts','categories'))
                        </ul>
                        @if($posts_total_count > count($posts))
                            @include(Helper::layout('assets.more_post'),array('user'=>Auth::user()->id,'post_limit'=>$post_limit,'route_name'=>'post.public.more.subscribes'))
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
                        @include(Helper::acclayout('assets.blog-list'),compact('blog_list'))
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