<?php
if ($result = AccountsPublicController::getTopBloggers()):
    extract($result);
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
        <a href="{{ pageurl('total-blogger-list') }}" class="right-content__all-link">All blogs</a>
    </div>
@endif