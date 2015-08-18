<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */


$hasBlogImage = $hasLogo = FALSE;
if (!empty($user->blogpicture) && File::exists(public_path($user->blogpicture))):
    $hasBlogImage = TRUE;
endif;
if (!empty($user->photo) && File::exists(public_path($user->photo))):
    $hasLogo = TRUE;
endif;
$top_ids = array();
$users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
        ->join('posts', 'posts_views.post_id', '=', 'posts.id')
        ->groupBy('posts.user_id')->orderBy('users_views', 'DESC')
        ->lists('users_views', 'post_user_id');
if ($users_top_posts):
    foreach (User::whereIn('id', array_keys($users_top_posts))->where('active', 1)->where('brand', 1)->take(10)->get() as $top_user):
        $top_ids[] = $top_user->id;
    endforeach;
endif;
$nickname = $user->id.'-'.BaseController::stringTranslite($user->name);
if(!empty($user->nickname)):
    $nickname = $user->nickname;
endif;
?>
@if(Route::currentRouteName() == 'user.profile.show')
<div style="{{ $hasBlogImage ? "background-image: url(".asset($user->blogpicture).")" : '' }}"
     class="brand-header {{ $hasBlogImage ? '' : 'without-image' }}">
    <div class="header__content">
        <div class="content__logo">
            @if($hasLogo)
                <img src="{{ asset($user->photo) }}">
            @endif
        </div>
        <div class="content__title"><span>{{ $user->name }}</span></div>
        <div class="content__desc"><span>{{ $user->blogname }}</span></div>
    </div>
    @if(count($top_ids) && in_array($user->id,$top_ids))
        <!-- <div class="header__best-top"></div> -->
    @endif
</div>
@else
    <div class="user-header user-page-header">
        <div data-empty-name="{{ $user->name }}" class="header__photo{{ !$hasLogo ? ' ava-empty ' : ' ' }}js-ava-cont">
            @if($hasLogo)
                <img src="{{ asset($user->photo) }}">
            @endif
            <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
        </div>
        <div class="header__info">
            @if($user->blogname != "")
                <div class="info__name js-fit-parent">
                    <h1 class="js-fit-text">{{ $user->blogname }}</h1>
                </div>
                <div class="info__quote">{{ $user->name }}</div>
            @else
                <div class="info__name js-fit-parent">
                    <h1 class="js-fit-text">{{ $user->name }}</h1>
                </div>
                <div class="info__quote"></div>
            @endif
            <div class="info__nav">
                <a href="{{ URL::route('user.profile.show', $nickname) }}" class="white-black-btn">Подробнее</a>
                @if(Auth::check() && Auth::user()->group_id == 4 && Auth::user()->id != $user->id)
                    @if(BloggerSubscribe::where('user_id',Auth::user()->id)->where('blogger_id',$user->id)->exists())
                        {{ Form::button('Добавлено в мой блог лист',array('class'=>'white-black-btn','disabled'=>'disabled')) }}
                    @else
                        {{ Form::open(array('route'=>'user.profile.subscribe','method'=>'post','class'=>'js-action-btn')) }}
                        {{ Form::hidden('user_id',$user->id) }}
                        {{ Form::button('Добавить в мой блог лист',array('class'=>'white-black-btn','type'=>'submit')) }}
                        {{ Form::close() }}
                    @endif
                @endif
                {{--<a href="#" class="white-black-btn">Монетизация</a>--}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header-hr"></div>
    <div style="{{ $hasBlogImage ? "background-image: url(".asset($user->blogpicture).")" : '' }}" class="brand-header{{ $hasBlogImage ? '' : 'without-image' }}"></div>
@endif