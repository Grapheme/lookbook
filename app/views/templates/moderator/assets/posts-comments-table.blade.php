<div class="left-title">Список комментариев</div>
<table class="moder-table">
    <thead>
    <tr>
        <th class="table__number">№</th>
        <th>Комментарий</th>
        <th>Пост</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($comments as $index => $comment)
        <tr class="js-post">
            <td class="table__number">1</td>
            <td>
                <div class="comments__item js-post">
                    <div class="left-block">
                        @include(Helper::layout('assets.avatar'),array('user'=>$comment->user,'showName'=>FALSE))
                    </div>
                    <div class="right-block">
                        <div class="right-block__pad">
                            <div class="comment-date">
                                <a href="{{ URL::route('user.posts.show',$comment->user->id.'-'.BaseController::stringTranslite($comment->user->name)) }}">{{ $comment->user->name }}</a>
                                | {{ $comment->created_at->diffForHumans() }}
                            </div>
                            <div class="comment-text">{{{ $comment->content }}}</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </td>
            <td>
                <a target="_blank"
                   href="{{ URL::route('post.public.show',array($comment->post->category_id.'-'.BaseController::stringTranslite($categories[$comment->post->category_id]),$comment->post->id.'-'.BaseController::stringTranslite($comment->post->title))) }}">
                    {{ $comment->post->title }}
                </a>
                <br>
                <br>
                <a target="_blank"
                   href="{{ URL::route('user.posts.show',$comment->post->user->id.'-'.BaseController::stringTranslite($comment->post->user->name)) }}">
                    {{ $comment->post->user->name }}
                </a>
                <br>

                <div style="margin-top: 5px;">
                    {{ $categories[$comment->post->category_id] }}
                </div>
            </td>
            <td>
                <div style="margin-bottom: 5px;">
                    <a href="{{ URL::route('post.public.show',array($comment->post->category_id.'-'.BaseController::stringTranslite($categories[$comment->post->category_id]),$comment->post->id.'-'.BaseController::stringTranslite($comment->post->title))) }}#comments" class="white-btn action-comment">
                        <i class="svg-icon icon-comments"></i>Комментировать
                    </a>
                </div>
                {{ Form::open(array('route'=>array('post.public.comment.destroy',$comment->id),'method'=>'delete','class'=>'js-delete-post inline-block')) }}
                    <button type="submit" autocomplete="off" class="white-btn action-delete"><i class="svg-icon icon-cross"></i>Удалить</button>
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>