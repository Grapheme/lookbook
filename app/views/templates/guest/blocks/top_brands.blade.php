<?php
$top_brands = AccountsPublicController::getTopBloggers(1);
?>
@if(count($top_brands))
<div class="right-title">Top brands</div>
<div class="right-content">
    <ul class="right-content__list top-bloggers">
        @foreach($top_brands as $top_brand)
            <li class="list__item">
                @include(Helper::layout('assets.avatar'),array('user'=>$top_brand))
                <span class="text__followers">{{ $top_brand['views'] }}</span>
            </li>
        @endforeach
    </ul>
    <a href="{{ pageurl('total-brands-list') }}" class="right-content__all-link">All brands</a>
</div>
@endif