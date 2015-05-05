<?php
$top_brands = array();
?>
@if(count($top_brands))
<div class="right-title">Top brands</div>
<div class="right-content">
    <ul class="right-content__list">
        @foreach($top_brands as $top_brand)
            <li class="list__item">
                @include(Helper::layout('assets.avatar'),array('user'=>$top_brand))
            </li>
        @endforeach
    </ul>
    <a href="javascript:void(0);" class="right-content__all-link">All brands</a>
</div>
@endif