<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
    $hasImage = FALSE;
    if(File::exists(public_path('uploads/users/'.Auth::user()->photo))):
        $hasImage = TRUE;
    endif;
?>
<div class="user-header">
    <div data-empty-name="{{ Auth::user()->name }} {{ Auth::user()->surname }}" class="header__photo{{ !$hasImage ? ' ava-empty ' : ' ' }}js-ava-cont">
        <img src="{{ asset(Config::get('site.theme_path').'/images/tmp/profile-photo_max.jpg') }}">
        <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
    </div>
    <div class="header__info">
        <div class="info__name js-fit-parent">
            <h1 class="js-fit-text">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h1>
        </div>
        <div class="info__auth-nav">
            <a href="{{ URL::route("dashboard") }}" {{ Helper::isRoute("dashboard") }} data-tab="dashboard">Дешборд</a>
            <a href="{{ URL::route("profile") }}" {{ Helper::isRoute("profile") }}>профиль</a>
            <a href="#" data-tab="notifications">Настройка уведомлений</a>
            <a href="#" data-tab="adv">Реклама</a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>