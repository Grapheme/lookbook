<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<header class="{{ @$header_class }}main-header">
    <div class="wrapper">
        @if(Request::is('/') || Request::is('en') || Request::is('ru'))
            <div class="logo">Графема</div>
        @else
            <a href="{{ URL::to(Config::get('app.locale')) }}" class="logo">Графема</a>
        @endif
        <nav class="main-nav">
             {{ Menu::placement('main_menu') }}
        </nav>
    </div>
</header>