<?php
$users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
        ->join('posts', 'posts_views.post_id', '=', 'posts.id')
        ->where('posts.category_id',$category_id)
        ->groupBy('posts.user_id')->orderBy('users_views','DESC')
        ->lists('users_views','post_user_id');
$top_brands = array();
if ($users_top_posts):
    $top_brends_ids = array();
    foreach(User::whereIn('id',array_keys($users_top_posts))->where('active',1)->where('brand',1)->take(Config::get('lookbook.count_top_bloggers'))->get() as $brand):
        $top_brands[$brand->id] = $brand;
        $top_brends_ids[] = $brand->id;
    endforeach;
    $users_top_posts_temp = $users_top_posts;
    $users_top_posts = array();
    foreach($users_top_posts_temp as $user_id => $users_views):
        if (in_array($user_id,$top_brends_ids)):
            $users_top_posts[$user_id] = $users_views;
        endif;
    endforeach;
    array_multisort($top_brands,SORT_DESC,array_keys($users_top_posts));
endif;
?>
@if(count($top_brands))
    <div class="right-title">TOP BRANDS OF {{ $category_name }}</div>
    <div class="right-content">
        <ul class="right-content__list top-bloggers">
            @foreach($top_brands as $top_brand)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$top_brand))
                    <span class="text__followers">{{ isset($users_top_posts[$top_brand->id]) ? $users_top_posts[$top_brand->id] : '' }}</span>
                </li>
            @endforeach
        </ul>
        <a href="{{ pageurl('total-blogger-list') }}" class="right-content__all-link">All blogs</a>
    </div>
@endif