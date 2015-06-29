@foreach($comments as $comment)
    <li class="dashboard-item js-post">
        <div class="left-block">
            @include(Helper::layout('assets.avatar'),array('user'=>$comment->user, 'showName' => FALSE))
        </div>
        <div class="right-block">
            <div class="right-block__pad">
                <div class="comment-date">
                    <a href="{{ URL::route('user.posts.show',$comment->user['id'].'-'.BaseController::stringTranslite($comment->user['name'])) }}">{{ $comment->user['name'] }}</a> | {{ $comment->created_at->diffForHumans() }}
                </div>
                <div class="comment-text">{{ $comment->content }}</div>
            </div>
            @if(Auth::check() && $comment->user_id == Auth::user()->id)
                <div class="post-actions">
                    {{ Form::open(array('route'=>array('post.public.comment.destroy',$comment->id),'method'=>'delete','class'=>'js-delete-post inline-block')) }}
                        <button type="submit" class="white-btn action-delete"><i class="svg-icon icon-cross"></i>Удалить</button>
                    {{ Form::close() }}
                </div>
            @endif
        </div>
        <div class="clearfix"></div>
    </li>
@endforeach