<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */

$posts_count = Post::where('user_id',Auth::user()->id)->count();
$posts = Post::where('user_id',Auth::user()->id)->orderBy('publish_at','DESC')->with('user','photo','category','subcategory','views','likes','comments')->limit(4)->get();
?>
@extends(Helper::acclayout())
@section('style')
@stop
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                @include(Helper::acclayout('assets.user_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                    @if($posts->count())
                        <div class="dashboard-btn">
                            <a href="{{ URL::route('posts.create') }}" class="white-black-btn">Создать новый пост</a>
                        </div>
                        <ul class="dashboard-list js-posts">
                        @foreach($posts as $post)
                            <?php
                                $hasAvatar = $hasImage = FALSE;
                                if(!empty($post->user->photo) && File::exists(public_path($post->user->photo))):
                                    $hasAvatar = TRUE;
                                endif;
                                if(!empty($post->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post->photo->name)):
                                    $hasImage = TRUE;
                                endif;
                            ?>
                            <li class="dashboard-item js-post">
                                <div class="left-block">
                                    <div data-empty-name="{{ $post->user->name }}" class="profile-ava ava-min{{ !$hasAvatar ? ' ava-empty ' : '' }}">
                                        @if($hasAvatar)
                                        <img src="{{ asset($post->user->photo) }}">
                                        @endif
                                        <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
                                    </div>
                                    <div class="profile-name">{{ $post->user->name }}</div>
                                </div>
                                <div class="right-block">
                                    <div class="right-block__pad">
                                        <div class="post-photo">
                                            @if($hasImage)
                                            <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post->photo->name) }}" alt="{{ $post->title }}">
                                            @endif
                                            @if(!empty($post->subcategory))
                                            <div class="post-photo__alt">
                                                {{ $post->subcategory->title }}
                                            @elseif(!empty($post->category))
                                            <div class="post-photo__alt">
                                                {{ $post->subcategory->title }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="post-info">
                                            <div class="post-info__title">
                                                <a href="{{ URL::route('posts.show',$post->id.'-'.BaseController::stringTranslite($post->title)) }}">{{ $post->title }}</a>
                                            </div>
                                            <div class="post-info__desc">
                                                {{ str_limit($post->content, $limit = 300, $end = '...')}}
                                            </div>
                                        </div>
                                        <div class="post-footer">
                                            <span class="post-footer__date">ЯНВ 26, 2015</span>
                                            <span class="post-footer__statisctics">
                                                <span class="statisctics-item">
                                                    <i class="svg-icon icon-eye"></i>24
                                                </span>
                                                <span class="statisctics-item">
                                                    <i class="svg-icon icon-like"></i>56
                                                </span>
                                                <span class="statisctics-item">
                                                    <i class="svg-icon icon-comments"></i>36
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="post-actions">
                                        <span class="actions__title">Действия</span>
                                        <span class="actions__btns">
                                            <a href="{{ URL::route('posts.edit',$post->id) }}" class="white-btn action-edit">
                                                <i class="svg-icon icon-edit"></i>Редактировать
                                            </a>
                                            <a href="javascript:void(0);" class="white-btn action-comment">
                                                <i class="svg-icon icon-comments"></i>Комментировать
                                            </a>
                                            {{ Form::open(array('route'=>array('posts.destroy',$post->id),'method'=>'delete','class'=>'js-delete-post inline-block')) }}
                                                <button type="submit" class="white-btn action-delete"><i class="svg-icon icon-cross"></i>Удалить</button>
                                            {{ Form::close() }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                        @if($posts_count > 2 && $posts_count > $posts->count())
                        <div class="dashboard-btn-more">
                            <form action="json/get_posts.json" class="js-more-posts">
                                <button type="submit" class="white-black-btn">Загрузить еще постов</button>
                                <p class="js-response-text"></p>
                            </form>
                        </div>
                        @endif
                    @else
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__desc">
                                У вас еще нет ни одной записи в блоге. Быстрее исправьте положение.
                            </div>
                            <a href="{{ URL::route('posts.create') }}" class="white-black-btn">Создать новый пост</a>
                        </div>
                    @endif
                    </div>
                    <div class="reg-content__right">
                        <div class="right-title">БЛОГИ РЕКОМЕНДОВАННЫЕ LOOKBOOK</div>
                        <div class="right-content">У вас еще нет рекомендованных блогов.</div>
                        <div class="right-title">МОЙ БЛОГ-ЛИСТ</div>
                        <div class="right-content">Вы еще не добавили ни один блог в свой блог-лист.<br>Читайте <a
                                    href="#">TOP POST</a> и выбирайте любимые.
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop
@section('scripts')
@stop