<?
/**
 * TITLE: Раздел (категория)
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
$post_limit = 1;
list($categories_lists,$tags_lists) = PostBloggerController::getCategoriesAndTags();
$posts = $tags = $promoted_posts = $categories = array();
$posts_total_count = 0;
$top_posts = $top_brands = $top_bloggers = array();
foreach(Dic::where('slug','categories')->first()->values as $category):
    $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
endforeach;
if ($category_id = Dic::where('slug','categories')->first()->value()->where('slug',$page->slug)->pluck('id')):
    $posts_total_count = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->count();
    $posts = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->with('user','photo','tags_ids','views','likes','comments')->take($post_limit)->get();
    $promoted_posts = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->where('in_promoted',1)->with('user','photo','tags_ids','views','likes','comments')->get();
    if (isset($tags_lists[$category_id]['category_tags'])):
        $tags = $tags_lists[$category_id]['category_tags'];
    endif;
else:
    App::abort(404);
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
            @if(count($promoted_posts))
                <ul class="posts-slider clearfix">
                @foreach($promoted_posts as $promoted_post)
                    <li class="slider__item">
                        @include(Helper::layout('assets.promoted'),array('promoted_post'=>$promoted_post,'categories'=>$categories))
                    </li>
                @endforeach
                </ul>
            @endif
                <div class="posts-slider__nav"></div>
            </div>
            <div class="clearfix"></div>
            @if(count($posts))
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <ul class="dashboard-list js-posts">
                            @include(Helper::layout('blocks.posts'),compact('posts','categories'))
                        </ul>
                        @if($posts_total_count > count($posts))
                        <div class="dashboard-btn-more">
                            {{ Form::open(array('route'=>'post.public.more','method'=>'post','class'=>'js-more-posts')) }}
                                {{ Form::hidden('category',@$category_id) }}
                                {{ Form::hidden('tag',Input::get('tag')) }}
                                {{ Form::hidden('limit',$post_limit) }}
                                {{ Form::hidden('from',$post_limit,array('id'=>'js-input-from','autocomplete'=>'off')) }}
                                {{ Form::submit('Показать больше '.@$categories[$category_id]['title'],array('class'=>'white-black-btn')) }}
                                <p class="js-response-text"></p>
                            {{ Form::close() }}
                        </div>
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