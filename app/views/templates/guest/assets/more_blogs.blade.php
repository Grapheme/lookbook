<div class="dashboard-btn-more">
    {{ Form::open(array('route'=>'blogs.public.more','method'=>'post','class'=>'js-more-posts')) }}
    {{ Form::hidden('user',@$user) }}
    {{ Form::hidden('limit',@$blogs_limit) }}
    {{ Form::hidden('from',@$blogs_limit,array('id'=>'js-input-from','autocomplete'=>'off')) }}
    {{ Form::button('Показать еще',array('class'=>'white-black-btn','type'=>'submit')) }}
    <p class="js-response-text"></p>
    {{ Form::close() }}
</div>