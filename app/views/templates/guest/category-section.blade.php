<?
/**
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
                <div class="js-top-split js-collage posts-slider-cont">
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
                        @include(Helper::layout('blocks.top_category_posts'),array('categories'=>$categories,'category_id'=>$category_id,'category_name'=>$categories[$category_id]['title']))
                        @include(Helper::layout('blocks.top_category_bloggers'),array('categories'=>$categories,'category_id'=>$category_id,'category_name'=>$categories[$category_id]['title']))
                        @include(Helper::layout('blocks.top_category_brands'),array('categories'=>$categories,'category_id'=>$category_id,'category_name'=>$categories[$category_id]['title']))
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