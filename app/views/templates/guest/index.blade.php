<?
/**
* TITLE: Главная страница
* AVAILABLE_ONLY_IN_ADVANCED_MODE
*/
if ($result = PostPublicController::indexPage()):
    extract($result);
endif;
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
        @if(count($promoted_posts))
            <div class="grid_12 js-list-slider">
                <div class="js-top-split posts-slider-cont">
                @foreach($promoted_posts as $promoted_post)
                    <li class="slider__item">
                        @include(Helper::layout('assets.promoted'),array('promoted_post'=>$promoted_post,'categories'=>$categories))
                    </li>
                    @endforeach
                </div>
                <div class="posts-slider__nav js-list-dots"></div>
            </div>
        @endif
            <div class="clearfix"></div>
        @if(count($posts) || count($promo_blocks))
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <ul class="dashboard-list js-posts">
                            @include(Helper::layout('blocks.promo_posts'),array('categories'=>$categories))
                            @include(Helper::layout('blocks.promo_sliders'),array('categories'=>$categories))
                            @include(Helper::layout('blocks.posts'),compact('posts','categories','post_access'))
                        </ul>
                    @if($posts_total_count > count($posts))
                        @include(Helper::layout('assets.more_post'),array('category_id'=>NULL,'tag'=>Input::get('tag'),'post_limit'=>$post_limit,'category_title'=>''))
                    @endif
                    </div>
                    <div class="reg-content__right">
                        @include(Helper::layout('blocks.top_posts'),compact('categories'))
                        @include(Helper::layout('blocks.top_bloggers'),compact('categories'))
                        @include(Helper::layout('blocks.top_brands'),compact('categories'))
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        @endif
        </div>
    </div>
</header>
@stop
@section('scripts')
@stop