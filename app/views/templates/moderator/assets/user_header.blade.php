<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
    $hasImage = FALSE;
    if(!empty(Auth::user()->thumbnail) && File::exists(public_path(Auth::user()->thumbnail))):
        $hasImage = TRUE;
    endif;
?>
<div class="user-header">
    <div data-empty-name="{{ Auth::user()->name }}" class="header__photo{{ !$hasImage ? ' ava-empty ' : ' ' }}js-ava-cont">
    @if($hasImage)
        <img src="{{ asset(Auth::user()->thumbnail) }}">
    @endif
        <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
    </div>
    <div class="header__info">
        <div class="info__name js-fit-parent">
            <h1 class="js-fit-text">{{ Auth::user()->name }}</h1>
        </div>
        <div class="info__auth-nav">
            <a href="{{ URL::route("dashboard") }}" {{ Helper::isRoute("dashboard") }} data-tab="dashboard">Дешборд</a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>