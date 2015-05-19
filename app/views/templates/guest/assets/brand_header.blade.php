<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */

$hasBlogImage = $hasLogo = FALSE;
if(!empty($user->blogpicture) && File::exists(Config::get('site.uploads_user_dir').'/'.$user->blogpicture)):
    $hasBlogImage = TRUE;
endif;
if(!empty($user->photo) && File::exists(Config::get('site.uploads_user_dir').'/'.$user->photo)):
    $hasLogo = TRUE;
endif;

$top_ids = array();
$users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
        ->join('posts', 'posts_views.post_id', '=', 'posts.id')
        ->groupBy('posts.user_id')->orderBy('users_views','DESC')
        ->lists('users_views','post_user_id');
if ($users_top_posts):
    foreach(User::whereIn('id',array_keys($users_top_posts))->where('active',1)->where('brand',1)->take(10)->get() as $top_user):
        $top_ids[] = $top_user->id;
    endforeach;
endif;
?>
<div style="{{ $hasBlogImage ? "background-image: url(".Config::get('site.uploads_file_user_dir').'/'.$user->blogpicture.")" : '' }}" class="brand-header">
    <div class="header__content">
        <div class="content__logo">
        @if($hasLogo)
            <img src="{{ Config::get('site.uploads_user_dir').'/'.$user->photo }}">
        @endif
        </div>
        <div class="content__title"><span>{{ $user->name }}</span></div>
        <div class="content__desc"><span>{{ $user->blogname }}</span></div>
    </div>
@if(count($top_ids) && in_array($user->id,$top_ids))
    <div class="header__best-top"></div>
@endif
</div>