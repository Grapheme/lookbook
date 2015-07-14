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


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter31418633 = new Ya.Metrika({
                    id:31418633,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31418633" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->