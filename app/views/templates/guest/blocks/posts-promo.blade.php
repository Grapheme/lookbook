@if(count($posts))
<li class="dashboard-item promo-block-full">
    <div class="left-block"></div>
    <div class="right-block">
        <div class="promo-slider js-list-slider">
            <div class="slider__name">Promo</div>
            <div class="slider__items">
        @foreach($posts as $post)
        <?php
            $hasImage = FALSE;
            if(!empty($post->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post->photo->name)):
                $hasImage = TRUE;
            endif;
        ?>
            @if(!empty($post->start_date) && !empty($post->stop_date))
                @if($hasImage)
                <?php
                    $link = 'javascript:void(0);';
                    if(!empty($post->link)):
                        $link = parse_url($post->link, PHP_URL_SCHEME)=='' ? 'http://'.$post->link : $post->link;
                    endif;
                ?>
                <a href="{{ $link }}" style="background-image: url({{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post->photo->name) }});" class="js-list-slide items__slide"></a>
                @else
                <a href="{{ $link }}" class="js-list-slide items__slide">{{ $post->video }}</a>
                @endif
            @endif
        @endforeach
            </div>
            <div class="slider__nav js-list-dots"></div>
        </div>
    </div>
</li>
@endif