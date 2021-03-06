<div class="post-comments">
@if(Auth::check())
    <div class="comments__title">Комментировать</div>
@else
    <div class="comments__title">Комментарии</div>
@endif
    <div class="comments__body">
        <a name="comments"></a>
        @if(Auth::check())
        <div class="comments__form">
            @include(Helper::layout('assets.avatar'),array('user'=>Auth::user(), 'showName' => FALSE))
            {{ Form::open(array('route'=>'post.public.comment.insert','method'=>'post','class'=>'js-comment-form')) }}
                {{ Form::hidden('post_id', $post->id) }}
                {{ Form::hidden('rating', 0) }}
                <div class="form__textearea-cont">
                    <textarea class="js-autosize" name="content"></textarea>
                </div>
                <div class="form__btn-cont">
                    {{ Form::button('Отправить',array('class'=>'white-black-btn','type'=>'submit')) }}
                </div>
                <p class="js-response-text"></p>
            {{ Form::close() }}
        </div>
        @endif
        <ul class="dashboard-list js-comments">
            @include(Helper::layout('blocks.comments'), compact('comments'))
        </ul>
    </div>
</div>