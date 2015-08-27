@if($brand_tags = BrandTags::where('user_id', Auth::user()->id)->with('photo')->orderBy('title')->get())
    <?php
    $nickname = $user->id . '-' . BaseController::stringTranslite($user->name);
    if (!empty($user->nickname)):
        $nickname = $user->nickname;
    endif;
    ?>
    <div class="right-title">Теги</div>
    <div class="right-content">
        <ul class="right-tags">
            @foreach($brand_tags as $tag)
                <?php $imageBackground = ''; ?>
                <?php  $tag_link = $tag->id . '-' . BaseController::stringTranslite($tag->title); ?>
                @if(!empty($tag->photo) && File::exists(Config::get('site.galleries_photo_dir') . '/' . $tag->photo->name))
                    <?php $imageBackground = 'style="background-image: url(' . asset(Config::get('site.galleries_photo_public_dir') . '/' . $tag->photo->name) . ')"'; ?>
                @endif
                <a href="{{ URL::route('user.posts.tag.show', array($nickname, $tag_link)) }}"
                   {{ $imageBackground }} class="tags__item">
                    <span class="item__text"><span>{{ $tag->title }}</span></span>
                </a>
            @endforeach
        </ul>
    </div>
@endif