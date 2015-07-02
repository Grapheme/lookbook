<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
$categories = array();
foreach (Dic::where('slug', 'categories')->first()->values as $category):
    $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
endforeach;
$blogs_total_count = Accounts::where('group_id', 4)->where('recommended', 1)->where('active', 1)->count();
$recommended_blogs = Accounts::where('group_id', 4)->where('recommended', 1)->where('active', 1)->with('me_signed')->take(Config::get('lookbook.blogs_limit'))->get();
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
                        <div class="left-title big-title">Рекомендованные блоги</div>
                        @if(count($recommended_blogs))
                            <ul class="blog-list js-posts">
                                @include(Helper::layout('blocks.bloggers'),array('blogs'=>$recommended_blogs))
                            </ul>
                            @if($blogs_total_count > count($recommended_blogs))
                                @include(Helper::layout('assets.more_blogs'),array('recommended' => 1,'blogs_limit'=>Config::get('lookbook.blogs_limit')))
                            @endif
                        @else
                            <div class="dashboard-empty">
                                <div class="dashboard-empty__desc">
                                    Блог лист пуст.
                                </div>
                            </div>
                        @endif
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