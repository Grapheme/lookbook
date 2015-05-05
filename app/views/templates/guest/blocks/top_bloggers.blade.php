<?php
$top_bloggers = array();
?>
@if(count($top_bloggers))
    <div class="right-title">Top bloggers</div>
    <div class="right-content">
        <ul class="right-content__list">
            @foreach($top_bloggers as $top_blogger)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$top_blogger))
                </li>
            @endforeach
        </ul>
        <a href="javascript:void(0);" class="right-content__all-link">All blogs</a>
    </div>
@endif