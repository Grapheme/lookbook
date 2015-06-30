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
        <tr class="js-post">
            <td class="table__number">1</td>
            <td>
                <div class="comments__item js-post">
                    <div class="left-block">
                        <a class="avatar-link" href="http://lookbook.dev/profile/3-moderator-saiyta/posts">
                            <span class="author__photo">
                                <span data-empty-name="Модератор сайта" class="profile-ava ava-min ava-empty">
                                    <div class="ava-image__empty"><span class="js-empty-chars">Мс</span></div>
                                </span>
                            </span>
                        </a>        
                    </div>
                    <div class="right-block">
                        <div class="right-block__pad">
                            <div class="comment-date">
                                <a href="http://lookbook.dev/profile/3-moderator-saiyta/posts">Модератор сайта</a> | 3 seconds ago
                            </div>
                            <div class="comment-text">123</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </td>
            <td>
                <a target="_blank" href="http://lookbook.dev/8-beauty/46-moiy-pervyiy-post-na-lookbook">
                    Мой первый пост на LookBook
                </a>
                <br>
                <br>
                <a target="_blank" href="http://lookbook.dev/profile/16-andrey-samoylov">
                    Andrey Samoylov
                </a>
                <br>
                <div style="margin-top: 5px;">
                    BEAUTY                
                </div>
            </td>
            <td>
                <div style="margin-bottom: 5px;">
                    <a href="#" class="white-btn action-comment">
                        <i class="svg-icon icon-comments"></i>Комментировать
                    </a>
                </div>
                <form method="POST" action="http://lookbook.dev/moderator/posts/46/delete" accept-charset="UTF-8" class="inline-block js-delete-post"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2pNYYxGb71jPXHSjjyX3WizXJ8rxiI7sEFGnhR7l">
                    <button class="white-btn action-delete" type="submit"><i class="svg-icon icon-cross"></i>Удалить</button>
                </form>
            </td>
        </tr>
        </tbody>
</table>
<div class="left-title">Список опубликованных постов</div>
<table class="moder-table">
    <thead>
    <th class="table__number">№<!--  п.п --></th>
    <th>Название</th>
    <!-- <th>Дата публикации</th> -->
    <th>Опубликован</th>
    <th></th>
    <th></th>
    </thead>
    <tbody>
    @foreach($posts as $index => $post)
        <tr class="js-post">
            <td class="table__number">{{ $index+1 }}</td>
            <td>
                <a target="_blank" href="{{ URL::route('post.public.show',array($post->category_id.'-'.BaseController::stringTranslite($categories[$post->category_id]),$post->id.'-'.BaseController::stringTranslite($post->title))) }}">
                    {{ $post->title }}
                </a>
                <br>
                <br>
                <a target="_blank" href="{{ URL::route('user.profile.show',$post->user->id.'-'.BaseController::stringTranslite($post->user->name)) }}">
                    {{ $post->user->name }}
                </a>
                <br>
                <div style="margin-top: 5px;">
                    {{ $categories[$post->category_id] }}                
                </div>
            </td>
            <!-- <td>{{ (new myDateTime())->setDateString($post->publish_at)->format('d.m.Y') }}</td> -->
            <td>{{ $post->updated_at->format('d.m.Y H:i') }}</td>
            <td class="table__actions js-slide-parent">
                <div class="js-slide-item hidden">
                    {{ Form::model($post,array('route'=>array('moderator.posts.publication',$post->id),'method'=>'post','class'=>'inline-block js-ajax-form','files'=>TRUE)) }}
                        {{ Form::checkbox('publication') }} Опубликован <br>
                        {{ Form::checkbox('in_index') }} Опубликовать на главную <br>
                        {{ Form::checkbox('in_section') }} Опубликовать в разделе <br>
                        {{ Form::checkbox('in_promoted') }} Продвигаемый пост <br><br>
                        Изображение поста: <br>
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