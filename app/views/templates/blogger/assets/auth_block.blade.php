<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<ul class="header__login">
    <li>
        <a href="{{ URL::route('dashboard') }}" class="header__user">
            <i class="svg-icon icon-uniE609"></i><span>{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
        </a>
    </li>
    <li><a href="{{ URL::route('logout') }}" class="login__enter">Выйти</a></li>
</ul>