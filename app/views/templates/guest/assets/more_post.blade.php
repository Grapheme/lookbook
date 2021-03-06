<?php
$route = isset($route_name) ? $route_name : 'post.public.more';
?>
<div class="dashboard-btn-more">
    {{ Form::open(array('route'=>$route,'method'=>'post','class'=>'js-more-posts')) }}
    {{ Form::hidden('search', Session::get('search_text')) }}
    {{ Form::hidden('publication',@$publication ? $publication : 1) }}
    {{ Form::hidden('user',@$user) }}
    {{ Form::hidden('category',@$category_id) }}
    {{ Form::hidden('tag',@$tag) }}
    {{ Form::hidden('limit',@$post_limit) }}
    {{ Form::hidden('from',@$post_limit,array('id'=>'js-input-from','autocomplete'=>'off')) }}
    {{ Form::button('Показать больше '.@$category_title,array('class'=>'white-black-btn','type'=>'submit')) }}
    <p class="js-response-text"></p>
    {{ Form::close() }}
</div>