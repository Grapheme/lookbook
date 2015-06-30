<?php
if (!isset($post_access)):
    $post_access = FALSE;
endif;
if (!isset($categories)):
    $categories = array();
    foreach (Dic::where('slug', 'categories')->first()->values as $category):
        $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
    endforeach;
endif;
?>
@foreach($posts as $post)
    <li class="dashboard-item{{ $post->in_advertising ? ' promo-block' : '' }} js-post">
        <div class="left-block">
            @include(Helper::layout('assets.avatar'),array('user'=>$post->user))
        </div>
        <div class="right-block">
            <div class="right-block__pad">
                @if($post->in_advertising)
                    @include(Helper::layout('assets.post-advertising'),array('post'=>$post,'categories'=>$categories))
                @else
                    @include(Helper::layout('assets.post'),array('post'=>$post,'categories'=>$categories))
                @endif
            </div>
            @if($post_access && Auth::check() && $post->user_id == Auth::user()->id)
                @include(Helper::acclayout('assets.post_actions'),array('post'=>$post))
            @endif
        </div>
    </li>
@endforeach