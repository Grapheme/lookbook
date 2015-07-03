@if(count($posts))
<?php
$showPosts = FALSE;
foreach($posts as $post):
    $start_data = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start_date)->timestamp;
    $stop_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->stop_date)->timestamp;
    if($post->start_date != '0000-00-00 00:00:00' && $post->stop_date != '0000-00-00 00:00:00'):
        if($start_data <= time() && $stop_date >= time()):
            $showPosts = TRUE;
        endif;
    endif;
endforeach;
?>
    @if($showPosts)
<li class="dashboard-item promo-block-full">
    <div class="left-block"></div>
    <div class="right-block">
        <div class="promo-slider js-list-slider">
            <div class="slider__name">Promo</div>
            <div class="slider__items">
        @foreach($posts as $post)
        <?php
            $start_data = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start_date)->timestamp;
            $stop_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->stop_date)->timestamp;
            $hasImage = $showPost = FALSE;
            if(!empty($post->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post->photo->name)):
                $hasImage = TRUE;
            endif;
            if($post->start_date != '0000-00-00 00:00:00' && $post->stop_date != '0000-00-00 00:00:00'):
                if($start_data <= time() && $stop_date >= time()):
                    $showPost = TRUE;
                endif;
            endif;

        ?>
            @if($showPost)
                @if($hasImage)
                <?php
                    $link = 'javascript:void(0);';
                    if(!empty($post->link)):
                        $link = parse_url($post->link, PHP_URL_SCHEME)=='' ? 'http://'.$post->link : $post->link;
                    endif;
                ?>
                <a href="{{ $link }}" style="background-image: url({{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post->photo->name) }});" class="js-list-slide items__slide"></a>
                @else
                <a href="javascript:void(0);" class="js-list-slide items__slide">{{ $post->video }}</a>
                @endif
            @endif
        @endforeach
            </div>
            <div class="slider__nav js-list-dots"></div>
        </div>
    </div>
</li>
    @endif
@endif