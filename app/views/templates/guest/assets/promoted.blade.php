<?php
if (is_object($promoted_post)):
    $promoted_post = $promoted_post->toArray();
endif;
$hasImage = FALSE; $background = '';
if(!empty($promoted_post['promoted_photo']) && File::exists(Config::get('site.galleries_photo_dir').'/'.$promoted_post['promoted_photo']['name'])):
    $hasImage = TRUE;
    $background = asset(Config::get('site.galleries_photo_public_dir').'/'.$promoted_post['promoted_photo']['name']);
elseif(!empty($promoted_post['photo']) && File::exists(Config::get('site.galleries_photo_dir').'/'.$promoted_post['photo']['name'])):
    $hasImage = TRUE;
    $background = asset(Config::get('site.galleries_photo_public_dir').'/'.$promoted_post['photo']['name']);
endif;
?>
<div style="background-image: url('{{ $background }}');" class="item__cont">
    <div class="post-card">
        <div class="item__date">
            <span class="post-photo__alt">
                {{ @$categories[$promoted_post['category_id']]['title'] }}
            </span>
            <span>
                {{ (new myDateTime())->setDateString($promoted_post['publish_at'].' 00:00:00')->custom_format('M d, Y') }}
            </span>
        </div>
        <div class="item__title">
            <a href="{{ URL::route('post.public.show',array($promoted_post['category_id'].'-'.BaseController::stringTranslite($categories[$promoted_post['category_id']]['slug']),$promoted_post['id'].'-'.BaseController::stringTranslite($promoted_post['title']))) }}">{{ $promoted_post['title'] }}</a>
        </div>
        <div class="item__author">
            @include(Helper::layout('assets.avatar'),array('user'=>$promoted_post['user']))
        </div>
    </div>
</div>