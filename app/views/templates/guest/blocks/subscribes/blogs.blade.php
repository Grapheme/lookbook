<?php
$top_blogger_ids = $top_brands_ids = array();
$users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
        ->join('posts', 'posts_views.post_id', '=', 'posts.id')
        ->groupBy('posts.user_id')->orderBy('users_views','DESC')
        ->lists('users_views','post_user_id');
if ($users_top_posts):
    foreach(User::whereIn('id',array_keys($users_top_posts))->where('active',1)->where('brand',0)->take(10)->get() as $top_user):
        $top_blogger_ids[] = $top_user->id;
    endforeach;
    foreach(User::whereIn('id',array_keys($users_top_posts))->where('active',1)->where('brand',1)->take(10)->get() as $top_user):
        $top_brands_ids[] = $top_user->id;
    endforeach;
endif;
?>
@foreach($blogs as $blog)
    <li class="list__item js-post">
    @include(Helper::layout('assets.avatar'),array('user'=>$blog,'showName'=>FALSE))
    @if($blog->brand == 0)
        @if(count($top_blogger_ids) && in_array($blog->id,$top_blogger_ids))
            <!-- <div class="item__best-blogger"></div> -->
        @endif
    @elseif($blog->brand == 1)
        @if(count($top_brands_ids) && in_array($blog->id,$top_brands_ids))
            <!-- <div class="item__best-blogger"></div> -->
        @endif
    @endif
        <div class="item__content">
            <div class="content__title">
                <a href="{{ URL::route('user.posts.show',$blog->id.'-'.BaseController::stringTranslite($blog->name)) }}">{{ $blog->name }}</a>
            </div>
            <div class="content__followers">
                <b>{{ $blog->me_signed->count() }}</b> {{ Lang::choice('подписчик|подписчика|подписчиков',$blog->me_signed->count()) }}
            </div>
            <div class="content__quote">
                {{ $blog->blogname }}
            </div>
            <div class="content__desc">
                {{ str_limit(strip_tags($blog->about), $limit = 300, $end = ' ...') }}
            </div>
            @include(Helper::acclayout('assets.blog_actions'),array('blog'=>$blog))
        </div>
    </li>
@endforeach