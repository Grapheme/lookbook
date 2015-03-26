<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */

$posts = Post::where('user_id',Auth::user()->id)->orderBy('publish_at','DESC')->with('photo','publication_type','category','subcategory','views_count','likes_count','comments_count')->get();
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
                            <li class="dashboard-item js-post">
                                <div class="left-block">
                                    <div data-empty-name="Анна Антропова" class="profile-ava ava-min ava-empty"><img
                                                src="images/tmp/profile-photo_max.jpg">

                                        <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
                                    </div>
                                    <div class="profile-name">Дурнев Константин</div>
                                </div>
                                <div class="right-block">
                                    <div class="right-block__pad">
                                        <div class="post-photo"><img src="images/tmp/post-photo-1.jpg" alt="">

                                            <div class="post-photo__alt">Shopping</div>
                                        </div>
                                        <div class="post-info">
                                            <div class="post-info__title"><a href="#">Новая коллекция обуви сезон
                                                    2014–2015</a></div>
                                            <div class="post-info__desc">В 1947 году, когда Европа только начала
                                                восстанавливаться после пятилетней войны, Кристиан Диор создал силуэт,
                                                который навсегда вошел в историю под названием New Look. Этим, без
                                                сомнения, главным своим изобретением дизайнер сделал выдающийся вклад в
                                                мировую моду.
                                            </div>
                                        </div>
                                        <div class="post-footer"><span
                                                    class="post-footer__date">ЯНВ 26, 2015</span><span
                                                    class="post-footer__statisctics"><span class="statisctics-item"><i
                                                            class="svg-icon icon-eye"></i>24</span><span class="statisctics-item"><i
                                                            class="svg-icon icon-like"></i>56</span><span
                                                        class="statisctics-item"><i class="svg-icon icon-comments"></i>36</span></span>
                                        </div>
                                    </div>
                                    <div class="post-actions"><span class="actions__title">Действия</span><a href="#"
                                                                                                             class="white-btn action-edit"><i
                                                    class="svg-icon icon-edit"></i>Редактировать</a><a href="#"
                                                                                                       class="white-btn action-comment"><i
                                                    class="svg-icon icon-comments"></i>Комментировать</a>

                                        <form action="json/test.json" class="js-delete-post inline-block">
                                            <button type="submit" class="white-btn action-delete"><i
                                                        class="svg-icon icon-cross"></i>Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="dashboard-btn-more">
                            <form action="json/get_posts.json" class="js-more-posts">
                                <button type="submit" class="white-black-btn">Загрузить еще постов</button>
                                <p class="js-response-text"></p>
                            </form>
                        </div>
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