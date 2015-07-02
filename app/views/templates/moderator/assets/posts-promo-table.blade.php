<div class="left-title">Список промо постов</div>
<table class="moder-table">
    <thead>
        <th class="table__number">№</th>
        <th>Название</th>
        <th>Опубликован</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
    @foreach($posts as $index => $post)
        <tr class="js-post">
            <td class="table__number">{{ $index+1 }}</td>
            <td>
                <a target="_blank"
                   href="{{ URL::route('post.public.show',array($post->category_id.'-'.BaseController::stringTranslite($categories[$post->category_id]),$post->id.'-'.BaseController::stringTranslite($post->title))) }}">
                    {{ $post->title }}
                </a>
                <br>
                <br>
                <a target="_blank"
                   href="{{ URL::route('user.profile.show',$post->user->id.'-'.BaseController::stringTranslite($post->user->name)) }}">
                    {{ $post->user->name }}
                </a>
                <br>

                <div style="margin-top: 5px;">
                    {{ $categories[$post->category_id] }}
                </div>
            </td>
            <td>{{ $post->updated_at->format('d.m.Y H:i') }}</td>
            <td class="table__delete">
                {{ Form::model($post,array('route'=>array('moderator.posts.delete',$post->id),'method'=>'delete','class'=>'inline-block js-delete-post')) }}
                {{ Form::button('<i class="svg-icon icon-cross"></i>Удалить',array('class'=>'white-btn action-delete','type'=>'submit')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>