@foreach($comments as $comment)
    <li class="dashboard-item js-post">
        <div class="left-block">
            @include(Helper::layout('assets.avatar'),array('user'=>$comment->user))
        </div>
        <div class="right-block">
            <div class="right-block__pad">
                {{ $comment->content }}
            </div>
            @if(Auth::check() && $comment->user_id == Auth::user()->id)
                <div class="post-actions">
                    {{ Form::open(array('route'=>array('post.public.comment.destroy',$comment->id),'method'=>'delete','class'=>'js-delete-post inline-block')) }}
                        <button type="submit" class="white-btn action-delete"><i class="svg-icon icon-cross"></i>Удалить</button>
                    {{ Form::close() }}
                </div>
            @endif
        </div>
    </li>
@endforeach