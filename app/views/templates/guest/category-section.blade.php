<?
/*
 * TITLE: Раздел (категория)
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
if ($result = PostPublicController::sectionCategory($page->slug)):
    extract($result);
else:
    exit(Redirect::route('mainpage'));
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
            <div class="grid_12">
                <div class="category-header">
                    <div class="header__title">{{ $page->seo->h1 }}</div>
                @if(count($tags))
                    <div class="header__links">
                    @foreach($tags as $tag_id => $tag_title)
                        <a href="{{ pageurl($page->slug,array('tag'=>$tag_id)) }}" {{ Request::has('tag') && Request::get('tag') == $tag_id ? 'class="active"':'' }}>{{ $tag_title }}</a>
                    @endforeach
                    </div>
                @endif
                </div>
            </div>
            <div class="clearfix"></div>
            @if(count($promoted_posts))
            <div class="grid_12 js-list-slider">
                <div class="js-top-split posts-slider-cont">
                    <!-- <ul class="posts-slider"> -->
                    @foreach($promoted_posts as $promoted_post)
                        <li class="slider__item">
                            @include(Helper::layout('assets.promoted'),array('promoted_post'=>$promoted_post,'categories'=>$categories))
                        </li>
                    @endforeach
                    <!-- </ul> -->
                </div>
                <div class="posts-slider__nav js-list-dots"></div>
            </div>
            @endif
            <div class="clearfix"></div>
            @if(count($posts))
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <ul class="dashboard-list js-posts">
                            @include(Helper::layout('blocks.posts'),compact('posts','categories','post_access'))
                        </ul>
                        @if($posts_total_count > count($posts))
                            @include(Helper::layout('assets.more_post'),array('category_id'=>$category_id,'tag'=>Input::get('tag'),'post_limit'=>$post_limit,'category_title'=>' '.$categories[$category_id]['title']))
                        @endif
                    </div>
                    <div class="reg-content__right">
                    @if(count($top_posts))
                        <div class="right-title">TOP POSTS</div>
                        <div class="right-content">
                            <ul class="right-content__list list-big">
                            @foreach($top_posts as $top_post)
                                <li class="list__item">
                                    @include(Helper::layout('assets.top_post'),array('top_post'=>$top_post,'categories'=>$categories))
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(count($top_bloggers))
                        <div class="right-title">Top bloggers</div>
                        <div class="right-content">
                            <ul class="right-content__list">
                            @foreach($top_bloggers as $top_blogger)
                                <li class="list__item">
                                    @include(Helper::layout('assets.avatar'),array('user'=>$top_blogger))
                                </li>
                            @endforeach
                            </ul>
                            <a href="javascript:void(0);" class="right-content__all-link">All blogs</a>
                        </div>
                    @endif
                    @if(count($top_brands))
                        <div class="right-title">Top brands</div>
                        <div class="right-content">
                            <ul class="right-content__list">
                            @foreach($top_brands as $top_brand)
                                <li class="list__item">
                                    @include(Helper::layout('assets.avatar'),array('user'=>$top_brand))
                                </li>
                            @endforeach
                            </ul>
                            <a href="javascript:void(0);" class="right-content__all-link">All brands</a>
                        </div>
                    @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
</header>
@stop
@section('scripts')
@stop