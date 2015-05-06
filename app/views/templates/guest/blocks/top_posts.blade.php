<?php
$top_posts = PostViews::select(DB::raw('post_id, count(*) as user_count'))->groupBy('post_id')->orderBy('user_count', 'DESC')
        ->with('post.user','post.photo','post.views')->take(Config::get('lookbook.count_top_posts'))
        ->get();
?>
@if(count($top_posts))
    <div class="right-title">TOP POSTS</div>
    <div class="right-content">
        <ul class="right-content__list list-big">
            @foreach($top_posts as $top_post)
                <li class="list__item">
                    @include(Helper::layout('assets.top_post'),array('top_post'=>$top_post->post,'categories'=>$categories))
                </li>
            @endforeach
        </ul>
    </div>
@endif