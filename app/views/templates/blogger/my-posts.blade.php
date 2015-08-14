<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */

$post_limit = Config::get('lookbook.posts_limit');
$post_access = TRUE;
$publication = 'all';
$posts_total_count = Post::where('user_id',Auth::user()->id)->count();
$blog_list = $categories = array();
if ($blogsIDs = BloggerSubscribe::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->take(5)->lists('blogger_id')):
    $blog_list = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->get();
endif;
$posts = Post::where('user_id',Auth::user()->id)->orderBy('publication','ASC')->orderBy('publish_at','DESC')->orderBy('id','DESC')->with('user','photo','tags_ids','views','likes','comments')->take($post_limit)->get();
foreach(Dic::where('slug','categories')->first()->values as $category):
    $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
endforeach;
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
                        @if($posts->count())
                            <div class="dashboard-btn">
                                <a href="{{ URL::route('posts.create') }}" class="white-black-btn">Создать новый пост</a>
                            </div>
                            <ul class="dashboard-list js-posts">
                                @include(Helper::layout('blocks.posts'),compact('posts','categories','post_access'))
                            </ul>
                            @if($posts_total_count > count($posts))
                                @include(Helper::layout('assets.more_post'),array('user'=>Auth::user()->id,'post_limit'=>$post_limit,'publication'=>$publication))
                            @endif
                        @else
                            @include(Helper::acclayout('assets.post_empty'))
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