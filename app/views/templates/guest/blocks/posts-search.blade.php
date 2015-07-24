<?php
$post_access = FALSE;
$categories = array();
foreach (Dic::where('slug', 'categories')->first()->values as $category):
    $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
endforeach;
?>
@foreach($posts as $post)
<?php
    $hasImage = FALSE;
    if(!empty($post->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post->photo->name)):
        $hasImage = TRUE;
    endif;
?>
    <li class="dashboard-item with-image js-post">
        <div class="left-block">
            @include(Helper::layout('assets.avatar'),array('user'=>$post->user))
        </div>
        <div class="right-block">
            @if($hasImage)
            <div style="background-image: url({{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post->photo->name) }});" class="right-block__image"></div>
            @endif
            <div class="right-block__pad">
                <div class="post-info">
                @if(isset($categories[$post->category_id]['title']))
                    <div class="post-photo__alt">
                        {{ $categories[$post->category_id]['title'] }}
                    </div>
                @endif
                    <div class="post-info__title">
                        <a href="{{ URL::route('post.public.show',array($post->category_id.'-'.BaseController::stringTranslite($categories[$post->category_id]['title']),$post->id.'-'.BaseController::stringTranslite($post->title))) }}">
                            {{ $post['title'] }}
                        </a>
                    </div>
                    <div class="post-info__desc">
                    @if(isset($excerpts[$post->id]))
                        {{ @$excerpts[$post->id] }}
                    @else
                        {{ str_limit(strip_tags($post->content), $limit = 500, $end = ' ...') }}
                    @endif
                    </div>
                </div>
                <div class="post-footer">
                    <span class="post-footer__date">
                        {{ (new myDateTime())->setDateString($post->publish_at.' 00:00:00')->custom_format('M d, Y') }}
                    </span>
                    <span class="post-footer__statisctics">
                        <span class="statisctics-item">
                            <i class="svg-icon icon-eye"></i>{{ count(@$post->views) }}
                        </span>
                        {{--<span class="statisctics-item js-like" data-post-id="{{ $post->id }}" data-action="json/like.json">--}}
                            {{--<i class="svg-icon icon-like"></i><span><span class="js-like-count">{{ count(@$post->likes) }}</span></span>--}}
                        {{--</span>--}}
                        <span class="statisctics-item">
                            <i class="svg-icon icon-comments"></i>{{ count(@$post->comments) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </li>
@endforeach