<?php
if (is_object($top_post)):
    $top_post = $top_post->toArray();
endif;
$hasImage = FALSE;
if(!empty($top_post['photo']) && File::exists(Config::get('site.galleries_photo_dir').'/'.$top_post['photo']['name'])):
    $hasImage = TRUE;
endif;
?>
@if($hasImage)
<a href="{{ URL::route('post.public.show',array($top_post['category_id'].'-'.BaseController::stringTranslite($categories[$top_post['category_id']]['slug']),$top_post['id'].'-'.BaseController::stringTranslite($top_post['title']))) }}" class="item__photo">
    <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$top_post['photo']['name']) }}" alt="{{ $top_post['title'] }}">
</a>
@endif
<div class="item__text">
    <div class="text__subject">
        <a href="{{ pageurl($categories[$top_post['category_id']]['slug']) }}">
            {{ @$categories[$top_post['category_id']]['title'] }}
        </a>
    </div>
    <div class="text__title">
        <a href="{{ URL::route('post.public.show',array($top_post['category_id'].'-'.BaseController::stringTranslite($categories[$top_post['category_id']]['slug']),$top_post['id'].'-'.BaseController::stringTranslite($top_post['title']))) }}">{{ $top_post['title'] }}</a>
    </div>
    <div class="text__author">
        <a href="javascript:void(0)">{{ $top_post['user']['name'] }}</a>
    </div>
    <div class="text__views">
        <i class="svg-icon icon-eye"></i>{{ $top_post['views'] }}
    </div>
</div>
<div class="clearfix"></div>