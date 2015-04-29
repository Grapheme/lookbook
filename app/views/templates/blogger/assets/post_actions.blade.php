<?php
if (is_object($post)):
    $post = $post->toArray();
endif;
?>
<div class="post-actions">
    <span class="actions__title">Действия</span>
    <a href="{{ URL::route('posts.edit',$post['id']) }}" class="white-btn action-edit">
        <i class="svg-icon icon-edit"></i>Редактировать
    </a>
    @if($post['publication'])
    <a href="javascript:void(0);" class="white-btn action-comment">
        <i class="svg-icon icon-comments"></i>Комментировать
    </a>
    @endif
    {{ Form::open(array('route'=>array('posts.destroy',$post['id']),'method'=>'delete','class'=>'js-delete-post inline-block')) }}
        <button type="submit" class="white-btn action-delete"><i class="svg-icon icon-cross"></i>Удалить</button>
    {{ Form::close() }}
</div>