<div class="post-actions">
    <a href="{{ URL::route('user.posts.show',$blog->id.'-'.BaseController::stringTranslite($blog->name)) }}" class="white-btn action-read">
        <i class="svg-icon icon-glasses"></i>Читать блог
    </a>
    <a href="{{ URL::route('user.profile.show',$blog->id.'-'.BaseController::stringTranslite($blog->name)) }}" class="white-btn action-view">
        <i class="svg-icon icon-person"></i>Просмотреть профиль
    </a>
    {{ Form::open(array('route'=>array('user.profile.subscribe.destroy'),'method'=>'delete','class'=>'js-delete-post inline-block')) }}
        {{ Form::hidden('user_id',$blog->id) }}
        <button type="submit" class="white-btn action-delete"><i class="svg-icon icon-cross"></i>Удалить</button>
    {{ Form::close() }}
</div>