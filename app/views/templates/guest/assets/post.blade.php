<?php
if (is_object($post)):
    $post = $post->toArray();
endif;
$hasImage = FALSE;
if(!empty($post['photo']) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post['photo']['name'])):
    $hasImage = TRUE;
endif;
?>
<a href="{{ URL::route('post.public.show',array($post['category_id'].'-'.BaseController::stringTranslite($categories[$post['category_id']]['title']),$post['id'].'-'.BaseController::stringTranslite($post['title']))) }}" class="post-photo">
@if($hasImage)
    <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post['photo']['name']) }}" alt="{{ $post['title'] }}">
@endif
@if(isset($categories[$post['category_id']]['title']))
    <span class="post-photo__alt">
        {{ $categories[$post['category_id']]['title'] }}
    </span>
@endif
</a>
<div class="post-info">
    <div class="post-info__title">
        <a href="{{ URL::route('post.public.show',array($post['category_id'].'-'.BaseController::stringTranslite($categories[$post['category_id']]['title']),$post['id'].'-'.BaseController::stringTranslite($post['title']))) }}">
            {{ $post['title'] }}
        </a>
    </div>
    <div class="post-info__desc">{{ str_limit(strip_tags($post['content']), $limit = 500, $end = ' ...') }}</div>
</div>
<div class="post-footer">
    @if($post['publication'])
    <span class="post-footer__date">{{ (new myDateTime())->setDateString($post['publish_at'].' 00:00:00')->custom_format('M d, Y') }}</span>
    <span class="post-footer__statisctics">
        <span class="statisctics-item">
            <i class="svg-icon icon-eye"></i>{{ count(@$post['views']) + @$post['guest_views'] }}
        </span>
        <a href="#" class="statisctics-item js-like" data-post-id="{{ $post['id'] }}" data-action="json/like.json">
            <i class="svg-icon icon-like"></i><span><span class="js-like-count">{{ count(@$post['likes']) }}</span></span>
        </a>
        <span class="statisctics-item">
            <i class="svg-icon icon-comments"></i>{{ count(@$post['comments']) }}
        </span>
    </span>
    @else
        <span class="post-footer__date">Черновик</span>
    @endif
</div>