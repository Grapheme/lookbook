<?php
if(!isset($post_access)):
    $post_access = FALSE;
endif;
?>
@foreach($posts as $post)
    <li class="dashboard-item js-post">
        <div class="left-block">
            @include(Helper::layout('assets.avatar'),array('user'=>$post->user))
        </div>
        <div class="right-block">
            <div class="right-block__pad">
                @include(Helper::layout('assets.post'),array('post'=>$post,'categories'=>$categories))
            </div>
        @if($post_access && Auth::check() && $post->user_id == Auth::user()->id)
            @include(Helper::acclayout('assets.post_actions'),array('post'=>$post))
        @endif
        </div>
    </li>
@endforeach