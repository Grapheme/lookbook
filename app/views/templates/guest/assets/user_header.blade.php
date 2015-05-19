<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */

$top_ids = array();
$users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
        ->join('posts', 'posts_views.post_id', '=', 'posts.id')
        ->groupBy('posts.user_id')->orderBy('users_views','DESC')
        ->lists('users_views','post_user_id');
if ($users_top_posts):
    foreach(User::whereIn('id',array_keys($users_top_posts))->where('active',1)->where('brand',$user->brand)->take(10)->get() as $top_user):
        $top_ids[] = $top_user->id;
    endforeach;
endif;
    $hasImage = FALSE;
    if(!empty($user->thumbnail) && File::exists(public_path($user->thumbnail))):
        $hasImage = TRUE;
    endif;
?>
<div class="user-header user-page-header">
    <div data-empty-name="{{ $user->name }}" class="header__photo{{ !$hasImage ? ' ava-empty ' : ' ' }}js-ava-cont">
    @if($hasImage)
        <img src="{{ asset($user->thumbnail) }}">
    @endif
        <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
    </div>
    <div class="header__info">
        <div class="info__name js-fit-parent">
            <h1 class="js-fit-text">{{ $user->name }}</h1>
        </div>
        <div class="info__quote">{{ $user->blogname }}</div>
        <div class="info__nav">
            <a href="javascript:void(0);" class="white-black-btn">Все посты {{ $user->brand ? 'бренда' : 'блогера' }}</a>
            @if(Auth::check() && Auth::user()->group_id == 4 && Auth::user()->id != $user->id)
            {{ Form::open(array('route'=>'user.profile.subscribe','method'=>'post','class'=>'js-action-btn')) }}
                {{ Form::hidden('user_id',$user->id) }}
                {{ Form::submit('Добавить в мой блог лист',array('class'=>'white-black-btn')) }}
            {{ Form::close() }}
            @endif
        </div>
    </div>
    <div class="clearfix"></div>
@if(count($top_ids) && in_array($user->id,$top_ids))
    <div class="header__best-top"></div>
@endif
</div>