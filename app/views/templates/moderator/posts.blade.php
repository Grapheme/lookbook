<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
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
                        @include(Helper::acclayout('assets.posts-table'),compact('posts'))
                        {{ $posts->links() }}
                    @else
                        <p>Нет опубликованных постов</p>
                    @endif
                    </div>
                    <div class="reg-content__right">
                        <div class="right-title">Статистика</div>
                        <div class="right-content">Всего постов: {{ Post::where('publication',1)->count() }}</div>
                        <div class="right-content">На главной: {{ Post::where('publication',1)->where('in_index',1)->count() }}</div>
                        <div class="right-title">По разделам</div>
                        @foreach($categories as $category_id => $category)
                        <div class="right-content">{{ $category }}: {{ Post::where('publication',1)->where('in_section',1)->where('category_id',$category_id)->count() }}</div>
                        @endforeach
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