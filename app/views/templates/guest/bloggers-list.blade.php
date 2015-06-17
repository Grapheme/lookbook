<?
/**
* TITLE: Список блогеров
* AVAILABLE_ONLY_IN_ADVANCED_MODE
*/
$categories = array();
foreach (Dic::where('slug', 'categories')->first()->values as $category):
    $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
endforeach;
if ($result = AccountsPublicController::getTopBloggers()):
    extract($result);
endif;
$blogs_limit = Config::get('lookbook.blogs_limit');
$blogs_total_count = Accounts::where('group_id', 4)->where('active', 1)->where('brand', 0)->count();
$blogs = Accounts::where('group_id', 4)->where('active', 1)->where('brand', 0)->with('me_signed')->take($blogs_limit)->get();
?>
@extends(Helper::layout())
@section('style')
@stop
@section('page_class')
@stop
@section('content')
<header>
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                <div class="category-header header-lite border-none">
                    <div class="header__title">{{ $page->seo->h1 }}</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                    @if(isset($top_bloggers) && count($top_bloggers))
                        <div class="left-title">Top bloggers</div>
                        <ul class="blog-list">
                        @foreach($top_bloggers as $blog)
                            <li class="list__item">
                                @include(Helper::layout('assets.avatar'),array('user'=>$blog,'showName'=>FALSE))
                                <div class="item__best-blogger"></div>
                                <div class="item__content">
                                    <div class="content__title">
                                        <a href="{{ URL::route('user.profile.show',$blog->id.'-'.BaseController::stringTranslite($blog->name)) }}">{{ $blog->name }}</a>
                                    </div>
                                    <div class="content__followers">
                                        <b>{{ $blog->me_signed->count() }}</b> {{ Lang::choice('подписчик|подписчика|подписчиков',$blog->me_signed->count()) }}
                                    </div>
                                    <div class="content__quote">
                                        {{ $blog->blogname }}
                                    </div>
                                    <div class="content__desc">
                                        {{ str_limit(strip_tags($blog->about), $limit = 300, $end = ' ...') }}
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(count($blogs))
                        <div class="left-title">All bloggers</div>
                        <ul class="blog-list js-posts">
                            @include(Helper::layout('blocks.bloggers'),array('blogs'=>$blogs))
                        </ul>
                        @if($blogs_total_count > count($blogs))
                            @include(Helper::layout('assets.more_blogs'),array('brand'=>0))
                        @endif
                    @endif
                    </div>
                    <div class="reg-content__right">
                        @include(Helper::layout('blocks.top_posts'),compact('categories'))
                        @include(Helper::layout('blocks.top_brands'),compact('categories'))
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</header>
@stop
@section('scripts')
@stop