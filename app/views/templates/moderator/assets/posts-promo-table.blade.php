@if(count($posts))
<?php
    if(!isset($position)):
        $position = 0;
    endif;
    $showPosts = FALSE;
    foreach($posts as $post):
        if($post->position == $position):
            $showPosts = TRUE;
        endif;
    endforeach;
?>
    @if($showPosts)
    <table class="moder-table">
        <thead>
            <th class="table__number">№</th>
            <th>Информация</th>
            <th></th>
        </thead>
        <tbody>
        @foreach($posts as $post)
        <?php
            $hasImage = FALSE;
            if(!empty($post->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post->photo->name)):
                $hasImage = TRUE;
            endif;
        ?>
            @if($post->position == $position)
            <tr class="js-post">
                <td class="table__number">{{ $post->order }}</td>
                <td class="table__promo">
                    @if($hasImage)
                    <div class="promo__image">
                        <a href="{{ parse_url($post->link, PHP_URL_SCHEME)=='' ? 'http://'.$post->link : $post->link }}" class="image__link"
                           style="background-image: url({{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post->photo->name) }});">
                        </a>
                    </div>
                    @endif
                    <div class="promo__info">
                        <div class="info__link">
                            <a href="{{ parse_url($post->link, PHP_URL_SCHEME)=='' ? 'http://'.$post->link : $post->link }}">
                                {{ parse_url($post->link, PHP_URL_SCHEME)=='' ? 'http://'.$post->link : $post->link }}
                            </a>
                        </div>
                        <div class="info__date">
                            {{ (new myDateTime())->setDateString($post->start_date)->format('d.m.Y') }}
                            -
                            {{ (new myDateTime())->setDateString($post->stop_date)->format('d.m.Y') }}
                        </div>
                    </div>
                </td>
                <td class="table__actions js-slide-parent">
                    <a href="{{ URL::route('moderator.promo.edit', $post->id) }}" class="white-btn">Редактировать</a>
                    {{ Form::open(array('route'=>array('moderator.promo.destroy',$post->id),'method'=>'delete','class'=>'js-delete-post','style'=>'margin-top: 10px')) }}
                        <button class="white-btn action-delete" type="submit"><i class="svg-icon icon-cross"></i>Удалить</button>
                    {{ Form::close() }}
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    @else
        Промо посты отсутствуют
    @endif
@endif