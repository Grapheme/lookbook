<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<?php
foreach (Dic::where('slug', 'categories')->first()->values as $category):
    $page_data['categories'][$category->id] = array('slug' => $category->slug, 'title' => $category->name);
endforeach;
$post_access = FALSE;
$post_limit = Config::get('lookbook.posts_limit');
if ($blogsIDs = BloggerSubscribe::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->lists('blogger_id')):
    $blog_list = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->take(5)->get();
    $posts_total_count = Post::whereIn('user_id', $blogsIDs)->where('in_advertising', 0)->count();
    $posts = Post::whereIn('user_id', $blogsIDs)->where('in_advertising', 0)->where('publication', 1)->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->take($post_limit)->get();
    $posts_advertising = Post::whereIn('user_id', $blogsIDs)->where('in_advertising', 1)->where('publication', 1)->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->take(1)->get();
    $promo_posts = PostPromo::where('position', 0)->where('in_line', 1)->orderBy('order')->with('photo')->get();
endif;
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
                                @include(Helper::layout('blocks.posts-advertising'), array('posts'=>$posts_advertising,'categories'=>$categories))
                                @include(Helper::layout('blocks.posts-promo'),array('posts'=>$promo_posts))
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
                        @include(Helper::acclayout('assets.recommended-list'))
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