<?php
$top_posts = AccountsPublicController::getTopPosts();
?>
@if(count($top_posts))
    <div class="right-title">TOP POSTS</div>
    <div class="right-content">
        <ul class="right-content__list list-big">
            @foreach($top_posts as $top_post)
                @if($top_post['views'])
                <li class="list__item">
                    @include(Helper::layout('assets.top_post'),array('top_post'=>$top_post,'categories'=>$categories))
                </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif