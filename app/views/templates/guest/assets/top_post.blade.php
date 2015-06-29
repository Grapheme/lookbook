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
<a href="{{ URL::route('post.public.show',array($top_post['category_id'].'-'.BaseController::stringTranslite($categories[$top_post['category_id']]['slug']),$top_post['id'].'-'.BaseController::stringTranslite($top_post['title']))) }}" style="background-image: url('{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$top_post['photo']['name']) }}');" class="item__photo"></a>
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
        @include(Helper::layout('assets.avatar'),array('user'=>$top_post['user'],'no_avatar'=>TRUE))
    </div>
    <div class="text__views">
        <i class="svg-icon icon-eye"></i>{{ count($top_post['views']) }}
    </div>
</div>
<div class="clearfix"></div>