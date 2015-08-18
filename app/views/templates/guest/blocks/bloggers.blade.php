@foreach($blogs as $blog)
<?php
    $nickname = $blog->id.'-'.BaseController::stringTranslite($blog->name);
    if(!empty($blog->nickname)):
        $nickname = $blog->nickname;
    endif;
?>
    <li class="list__item">
        @include(Helper::layout('assets.avatar'),array('user'=>$blog,'showName'=>FALSE))
        <div class="item__content">
            <div class="content__title">
                <a href="{{ URL::route('user.posts.show', $nickname) }}">{{ $blog->name }}</a>
            </div>
            <div class="content__followers">
                <b>{{ $blog->me_signed->count() }}</b> {{ Lang::choice('подписчик|подписчика|подписчиков',$blog->me_signed->count()) }}
            </div>
            <div class="content__quote">
                {{ $blog->blogname }}
            </div>
            <div class="content__desc">
                {{ str_limit(strip_tags($blog->about), $limit = 300, $end = ' ...') }}
            </div>
        </div>
    </li>
@endforeach