<?php
$promo_sliders = array();
?>
@foreach($promo_sliders as $slider)
<li class="dashboard-item promo-block-full">
    <div class="left-block"></div>
    <div class="right-block">
        <div class="promo-slider js-list-slider">
            <div class="slider__name">Promo</div>
            <div class="slider__items">
                <a href="javascript:void(0);" style="background-image: url({{ Config::get('site.theme_path') }}/images/tmp/promo_big.jpg);" class="js-list-slide items__slide"></a>
                <a href="javascript:void(0);" style="background-image: url({{ Config::get('site.theme_path') }}/images/tmp/promo_big.jpg);" class="js-list-slide items__slide"></a>
                <a href="javascript:void(0);" style="background-image: url({{ Config::get('site.theme_path') }}/images/tmp/promo_big.jpg);" class="js-list-slide items__slide"></a>
            </div>
            <div class="slider__nav js-list-dots">
            </div>
        </div>
    </div>
</li>
@endforeach