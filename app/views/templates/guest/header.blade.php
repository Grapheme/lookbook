<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<header class="header">
    <div class="header__top">
        <div class="wrapper">
            <div class="container_12">
                <div class="grid_12">
                    <nav class="header__nav">
                        {{ Menu::placement('main_menu') }}
                    </nav>
                    @if(Auth::guest())
                    <ul class="header__login">
                        <li><a href="#reg" class="login__create-blog">Создать блог</a></li>
                        <li><a href="#auth" class="login__enter">Войти</a></li>
                    </ul>
                    @else
                        @include(Helper::acclayout('assets.auth_block'))
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                <div class="header__bottom"><a href="#" class="bottom__search"></a>
                    @if (Request::is('/'))
                        <div class="bottom__logo"></div>
                    @else
                        <a class="bottom__logo" href="{{ pageurl('about') }}"></a>
                    @endif
                    <nav class="bottom__nav">
                        {{ Menu::placement('categories_menu') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>