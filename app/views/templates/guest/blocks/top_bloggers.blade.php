<?php
$users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
        ->join('posts', 'posts_views.post_id', '=', 'posts.id')
        ->groupBy('posts.user_id')->orderBy('users_views','DESC')
        ->lists('users_views','post_user_id');
$top_bloggers = array();
if ($users_top_posts):
    $top_bloggers_ids = array();
    foreach(User::whereIn('id',array_keys($users_top_posts))->where('active',1)->where('brand',0)->take(Config::get('lookbook.count_top_bloggers'))->get() as $blogger):
        $top_bloggers[$blogger->id] = $blogger;
        $top_bloggers_ids[] = $blogger->id;
    endforeach;
    $users_top_posts_temp = $users_top_posts;
    $users_top_posts = array();
    foreach($users_top_posts_temp as $user_id => $users_views):
        if (in_array($user_id,$top_bloggers_ids)):
            $users_top_posts[$user_id] = $users_views;
        endif;
    endforeach;
    array_multisort($top_bloggers,SORT_DESC,array_keys($users_top_posts));
endif;
?>
@if(count($top_bloggers))
    <div class="right-title">Top BLOGGERS</div>
    <div class="right-content">
        <ul class="right-content__list top-bloggers">
            @foreach($top_bloggers as $top_blogger)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$top_blogger))
                    <span class="text__followers">{{ isset($users_top_posts[$top_blogger->id]) ? $users_top_posts[$top_blogger->id] : '' }}</span>
                </li>
            @endforeach
        </ul>
        <a href="javascript:void(0);" class="right-content__all-link">All blogs</a>
    </div>
@endif