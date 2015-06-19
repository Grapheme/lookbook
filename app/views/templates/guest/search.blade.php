<?
/**
 * TITLE: Результаты поиска
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
$posts = array();
$posts_total_count = 0;
$categories = array();
foreach (Dic::where('slug', 'categories')->first()->values as $category):
    $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
endforeach;
if(Session::has('search_text')):
    $posts_total = SearchPublicController::getResult(Session::get('search_text'));
    $posts_total_count = count($posts_total);
    $posts = SearchPublicController::getResult(Session::get('search_text'), Config::get('lookbook.posts_limit'));
    $excerpts = SearchPublicController::resultBuildExcerpts($posts, Session::get('search_text'));
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
                            @include(Helper::layout('blocks.posts-search'),compact('posts', 'excerpts'))
                        </ul>
                        @if($posts_total_count > count($posts))
                            @include(Helper::layout('assets.more_post'),array('post_limit'=>Config::get('lookbook.posts_limit'),'route_name'=>'post.public.more.search'))
                        @endif
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