<?php
$top_bloggers = AccountsPublicController::getTopBloggers(0, $category_id);
?>
@if(count($top_bloggers))
    <div class="right-title">Top BLOGGERS OF {{ $category_name }}</div>
    <div class="right-content">
        <ul class="right-content__list top-bloggers">
            @foreach($top_bloggers as $top_blogger)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$top_blogger))
                    <span class="text__followers">{{ $top_blogger['views'] }}</span>
                </li>
            @endforeach
        </ul>
        <a href="{{ pageurl('total-blogger-list') }}" class="right-content__all-link">All blogs</a>
    </div>
@endif