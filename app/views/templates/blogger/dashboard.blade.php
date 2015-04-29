<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */

$post_limit = Config::get('lookbook.posts_limit');
$post_access = TRUE;
$publication = 'all';
$posts_total_count = Post::where('user_id',Auth::user()->id)->count();
$recommended_blogs = $blog_list = $categories = array();

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
                        <div class="right-title">БЛОГИ РЕКОМЕНДОВАННЫЕ LOOKBOOK</div>
                        <div class="right-content">
                        @if(count($recommended_blogs))
                            <ul class="right-content__list">
                            @foreach($recommended_blogs as $recommended_blog)
                                <li class="list__item">
                                    @include(Helper::layout('assets.avatar'),array('user'=>$recommended_blog))
                                </li>
                            @endforeach
                            </ul>
                            <a href="javascript:void(0);" class="right-content__all-link">All blogs</a>
                        @else
                            У вас еще нет рекомендованных блогов.
                        @endif
                        </div>
                        <div class="right-title">МОЙ БЛОГ-ЛИСТ</div>
                        <div class="right-content">
                        @if(count($blog_list))
                            <ul class="right-content__list">
                            @foreach($blog_list as $blog)
                                <li class="list__item">
                                    @include(Helper::layout('assets.avatar'),array('user'=>$blog))
                                </li>
                            @endforeach
                            </ul>
                            <a href="javascript:void(0);" class="right-content__all-link">All blogs</a>
                        @else
                            Вы еще не добавили ни один блог в свой блог-лист.<br>Читайте <a href="javascript:void(0);">TOP POST</a> и выбирайте любимые.
                        @endif
                        </div>
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