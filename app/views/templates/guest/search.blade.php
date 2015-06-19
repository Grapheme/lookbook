<?
/**
 * TITLE: Результаты поиска
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
$posts = array();
$posts_total_count = 0;
if(Session::has('search_text')):
    $posts_total = SearchPublicController::getResult(Session::get('search_text'));
    $posts_total_count = count($posts_total);
    $posts = SearchPublicController::getResult(Session::get('search_text'), Config::get('lookbook.posts_limit'));
endif;
?>
@extends(Helper::layout())
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                <div class="category-header header-lite border-bottom-none">
                    <div class="header__title">Результаты поиска</div>
                </div>
                <div class="search__header">
                    {{ Form::open(array('url'=>URL::route('search.public.request'), 'class'=>'js-search-form')) }}
                        <div class="block__input">
                            {{ Form::button('',array('type'=>'submit')) }}
                            {{ Form::text('search_text',NULL,array('placeholder'=>'Новый поиск')) }}
                        </div>
                        {{ Form::button('Найти',array('type'=>'submit', 'class'=>'us-btn blue-hover search-btn')) }}
                        <a href="#" class="js-close-search block__close"></a>
                    {{ Form::close() }}
                    @if(Session::has('search_text'))
                    <div class="header__desc">
                        Вы искали «<b>{{ Session::get('search_text') }}</b>»
                    </div>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content border-none">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        @if(empty($posts))
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__desc">Ничего не найдено</div>
                        </div>
                        <div class="left-title search-title">Посты <b>{{ Post::where('publication', 1)->count() }}</b></div>
                        @else
                        <ul class="dashboard-list list-search js-posts">
                            @include(Helper::layout('blocks.posts-search'),compact('posts'))
                            <li class="dashboard-item with-image js-post">
                                <div class="left-block">
                                    <div data-empty-name="Анна Антропова" class="profile-ava ava-min ava-empty"><img src="images/tmp/profile-photo_max.jpg">
                                        <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
                                    </div>
                                    <div class="profile-name">Дурнев Константин</div>
                                </div>
                                <div class="right-block">
                                    <div style="background-image: url(images/tmp/post-photo-1.jpg);" class="right-block__image"></div>
                                    <div class="right-block__pad">
                                        <div class="post-info">
                                            <div class="post-photo__alt"><a href="#">Shopping</a></div>
                                            <div class="post-info__title"><a href="post.html">Новая коллекция обуви сезон 2014–2015</a></div>
                                            <div class="post-info__desc">В 1947 году, когда Европа только начала восстанавливаться после пятилетней войны, Кристиан Диор создал силуэт, который навсегда вошел в историю под названием New Look. Этим, без сомнения, главным своим изобретением дизайнер сделал выдающийся вклад в мировую моду. </div>
                                        </div>
                                        <div class="post-footer"><span class="post-footer__date">ЯНВ 26, 2015</span><span class="post-footer__statisctics"><span class="statisctics-item"><i class="svg-icon icon-eye"></i>24</span><span class="statisctics-item"><i class="svg-icon icon-like"></i>56</span><span class="statisctics-item"><i class="svg-icon icon-comments"></i>36</span></span></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                    <div class="reg-content__right">
                        @include(Helper::layout('blocks.top_posts'),compact('categories'))
                        @include(Helper::layout('blocks.top_bloggers'),compact('categories'))
                        @include(Helper::layout('blocks.top_brands'),compact('categories'))
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