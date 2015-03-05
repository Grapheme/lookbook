<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>


<footer class="{{ @$footer_class }}main-footer">
    <div class="wrapper">
        <div class="right-side"><a href="mailto:be.digital@grapheme.ru">be.digital@grapheme.ru</a><a href="https://www.facebook.com/grapheme.ru" target="_blank">facebook</a><a>#grapheme_ru</a></div>
        <div class="left-side">
            <span>{{ trans('interface.footer.copyright') }}, 2011 - {{ date('Y') }}</span>
            <!--<span class="lang-links">
                <a href="{{ URL::to('ru') }}">RU</a>
                <a href="{{ URL::to('en') }}">EN</a>
            </span>-->
        </div>
    </div>
</footer>