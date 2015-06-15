<?php
$promo_posts = array();
?>
@foreach($promo_posts as $post)
<li class="dashboard-item promo-block js-post">
    <div class="left-block">
        @include(Helper::layout('assets.avatar'),array('user'=>array('name'=>'Анна Антропова','photo'=>'')))
    </div>
    <div class="right-block">
        <div class="right-block__pad">
            @include(Helper::layout('assets.promo_post'),array('post'=>$post,'categories'=>$categories))
        </div>
    </div>
</li>
@endforeach