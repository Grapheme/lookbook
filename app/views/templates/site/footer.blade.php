<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<footer class="footer">
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                <div class="footer__top">
                    @if (Request::is('/'))
                        <div class="footer__logo"></div>
                    @else
                        <a class="footer__logo" href="{{ URL::route('mainpage') }}"></a>
                    @endif
                    <nav class="footer__nav">
                        {{ Menu::placement('footer_menu') }}
                    </nav>
                </div>
                <div class="footer__bottom"><span>© LookBook, 2014 - {{ date('Y') }}</span><span class="fl-r">Сделано в <a href="http://grapheme.ru" target="_blank">ГРАФЕМА</a></span></div>
            </div>
        </div>
    </div>
</footer>