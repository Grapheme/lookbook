<div class="left-title">Список опубликованных постов</div>
<table class="moder-table">
    <thead>
    <th>№<!--  п.п --></th>
    <th>Название</th>
    <th>Дата публикации</th>
    <th>Дата обновления</th>
    <!-- <th></th> -->
    </thead>
    <tbody>
    @foreach($posts as $index => $post)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>
                <a target="_blank" href="{{ URL::route('post.public.show',array($post->category_id.'-'.BaseController::stringTranslite($categories[$post->category_id]),$post->id.'-'.BaseController::stringTranslite($post->title))) }}">
                    {{ $post->title }}
                </a><br>
                {{ $categories[$post->category_id] }}
                <br>
                <a target="_blank" href="{{ URL::route('user.profile.show',$post->user->id.'-'.BaseController::stringTranslite($post->user->name)) }}">
                    {{ $post->user->name }}
                </a>
            </td>
            <td>{{ (new myDateTime())->setDateString($post->publish_at)->format('d.m.Y') }}</td>
            <td>{{ $post->updated_at->format('d.m.Y H:i') }}</td>
            <td class="table__actions">
                {{ Form::model($post,array('route'=>array('moderator.posts.publication',$post->id),'method'=>'post','class'=>'inline-block','files'=>TRUE)) }}
                    {{ Form::checkbox('publication') }} Опубликован <br>
                    {{ Form::checkbox('in_index') }} Опубликовать на главную <br>
                    {{ Form::checkbox('in_section') }} Опубликовать в разделе <br>
                    {{ Form::checkbox('in_promoted') }} Продвигаемый пост <br><br>
                    Изображение поста: <br>
                    {{ Form::file('photo') }}
                    {{ Form::button('Сохранить',array('class'=>'white-btn','type'=>'submit')) }}
                {{ Form::close() }}
            </td>
            <td>
                {{ Form::model($post,array('route'=>array('moderator.posts.delete',$post->id),'method'=>'delete','class'=>'inline-block')) }}
                    {{ Form::button('Удалить',array('class'=>'white-btn','type'=>'submit')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>