<?php
$top_posts = array();
?>
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