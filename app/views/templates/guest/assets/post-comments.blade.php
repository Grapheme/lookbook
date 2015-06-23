<div class="post-comments">
@if(Auth::check())
    <div class="comments__title">Комментировать</div>
@else
    <div class="comments__title">Комментарии</div>
@endif
    <div class="comments__body">
        @if(Auth::check())
        <div class="comment-form">
            @include(Helper::layout('assets.avatar'),array('user'=>$post->user))
            {{ Form::open(array('route'=>'post.public.comment.insert','method'=>'post','class'=>'js-ajax-form')) }}
                {{ Form::hidden('post_id', $post->id) }}
                {{ Form::hidden('rating', 0) }}
                {{ Form::textarea('content') }}
                {{ Form::button('Отправить',array('class'=>'white-black-btn','type'=>'submit')) }}
                <p class="js-response-text"></p>
            {{ Form::close() }}
        </div>
        @endif
        <ul class="dashboard-list js-posts">
            @include(Helper::layout('blocks.comments'), compact('comments'))
        </ul>
    </div>
</div>