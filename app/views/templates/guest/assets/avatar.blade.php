<?php
if (is_object($user)):
    $user = $user->toArray();
endif;
$hasAvatar = FALSE;
if(!empty($user['photo']) && File::exists(public_path($user['photo']))):
    $hasAvatar = TRUE;
endif;
if(!isset($showName)):
    $showName = TRUE;
endif;
?>
<a class="avatar-link" href="{{ URL::route('user.posts.show',$user['id'].'-'.BaseController::stringTranslite($user['name'])) }}">
    @if(isset($no_avatar) && $no_avatar === TRUE)
        {{ $user['name'] }}
    @else
    <span class="author__photo">
        <span data-empty-name="{{ $user['name'] }}" class="profile-ava ava-min{{ !$hasAvatar ? ' ava-empty ' : '' }}">
            @if($hasAvatar)
                <img src="{{ asset($user['photo']) }}">
            @endif
            <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
        </span>
    </span>
    @if($showName)
    <span class="profile-name"><span>{{ $user['name'] }}</span></span>
    @endif
@endif
</a>