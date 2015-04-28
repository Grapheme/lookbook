<?php
if (is_object($user)):
    $user = $user->toArray();
endif;
$hasAvatar = FALSE;
if(!empty($user['photo']) && File::exists(public_path($user['photo']))):
    $hasAvatar = TRUE;
endif;
?>
<a href="javascript:void(0);">
    <div class="author__photo">
        <div data-empty-name="{{ $user['name'] }}" class="profile-ava ava-min{{ !$hasAvatar ? ' ava-empty ' : '' }}">
            @if($hasAvatar)
                <img src="{{ asset($user['photo']) }}">
            @endif
            <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
        </div>
    </div>
    <div class="profile-name">{{ $user['name'] }}</div>
</a>