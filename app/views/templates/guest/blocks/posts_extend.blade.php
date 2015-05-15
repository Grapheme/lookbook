<?php
$posts_extend = array();
if (Request::has('tag')):

elseif(empty($posts_extend)):
    $posts_extend  = Post::where('publication',1)->where('id','!=',$post->id)->where('category_id',$post->category_id)->with('user','photo')->orderByRaw("RAND()")->take(3)->get();
elseif(empty($posts_extend)):
    $posts_extend  = Post::where('publication',1)->where('id','!=',$post->id)->with('user','photo')->orderByRaw("RAND()")->take(3)->get();
endif;
$categories = array();
foreach(Dic::where('slug','categories')->first()->values as $category):
    $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
endforeach;
?>
@if(count($posts_extend))
<div class="req-content__full">
    <div class="left-title">Посты по теме</div>
    <div class="full__content">
        <ul class="posts-list">
        @foreach($posts_extend as $post_ext)
        <?php
            $hasImage = FALSE;
            if(!empty($post_ext->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post_ext->photo->name)):
                $hasImage = TRUE;
            endif;
        ?>
            <li class="list__item post-card">
                <div class="item__cont">
                    <div class="post-photo">
                    @if($hasImage)
                        <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post_ext->photo->name) }}" alt="{{ $post_ext->title }}">
                    @endif
                    @if(isset($categories[$post->category_id]['title']))
                        <div class="post-photo__alt">
                            {{ $categories[$post->category_id]['title'] }}
                        </div>
                    @endif
                    </div>
                    <div class="item__date">{{ (new myDateTime())->setDateString($post_ext->publish_at.' 00:00:00')->custom_format('M d, Y') }}</div>
                    <div class="item__title">
                        <a href="{{ URL::route('post.public.show',array($post_ext->category_id.'-'.BaseController::stringTranslite($categories[$post_ext->category_id]['title']),$post_ext->id.'-'.BaseController::stringTranslite($post_ext->title))) }}">
                            {{ $post_ext->title }}
                        </a>
                    </div>
                    <div class="item__author">
                        @include(Helper::layout('assets.avatar'),array('user'=>$post_ext->user))
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif