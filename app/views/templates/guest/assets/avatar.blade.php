<?php
if (is_object($user)):
    $user = $user->toArray();
endif;
$hasAvatar = FALSE;
if(!empty($user['photo']) && File::exists(public_path($user['photo']))):
    $hasAvatar = TRUE;
endif;
?>
<span class="author__photo">
    <span data-empty-name="{{ $user['name'] }}" class="profile-ava ava-min{{ !$hasAvatar ? ' ava-empty ' : '' }}">
        @if($hasAvatar)
            <img src="{{ asset($user['photo']) }}">
        @endif
        <span class="ava-image__empty"><span class="js-empty-chars"></span></span>
    </span>
</span>
<span class="profile-name"><span>{{ $user['name'] }}</span></span>