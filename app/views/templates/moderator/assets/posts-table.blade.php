<div class="left-title">Список опубликованных постов</div>
<table class="moder-table">
    <thead>
        <th class="table__number">№</th>
        <th>Название</th>
        <th>Опубликован</th>
        <th>Последнее обновление</th>
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
            <td>{{ (new myDateTime())->setDateString($post->publish_at)->format('d.m.Y') }}</td>
            <td>{{ $post->updated_at->format('d.m.Y H:i') }}</td>
            <td class="table__actions js-slide-parent">
                <div class="js-slide-item hidden">
                    {{ Form::model($post,array('route'=>array('moderator.posts.publication',$post->id),'method'=>'post','class'=>'inline-block js-ajax-form','files'=>TRUE)) }}
                    {{ Form::checkbox('publication') }} Опубликован <br>
                    {{ Form::checkbox('in_index') }} Опубликовать на главную <br>
                    {{ Form::checkbox('in_section') }} Опубликовать в разделе <br>
                    {{ Form::checkbox('in_promoted') }} Продвигаемый пост <br>
                    {{ Form::checkbox('in_advertising') }} Рекламный пост <br><br>
                    Изображение продвигаемого поста: <br>
                    {{ Form::file('photo') }}
                    {{ Form::button('Сохранить',array('class'=>'white-btn actions__btn','type'=>'submit')) }}
                    {{ Form::close() }}
                </div>
                <div>
                    <a href="#" class="white-btn js-slide-link">Редактировать</a>
                </div>
            </td>
            <td class="table__delete">
                {{ Form::model($post,array('route'=>array('moderator.posts.delete',$post->id),'method'=>'delete','class'=>'inline-block js-delete-post')) }}
                {{ Form::button('<i class="svg-icon icon-cross"></i>Удалить',array('class'=>'white-btn action-delete','type'=>'submit')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>