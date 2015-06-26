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
                    <div class="req-content__full border-none">
                        <div class="left-title">Статистика</div>
                        <div class="full__content">
                            <p>Всего постов: {{ Post::where('publication',1)->count() }}</p>
                            <p>На главной: {{ Post::where('publication',1)->where('in_index',1)->count() }}</p>
                        </div>
                        <div class="left-title">По разделам</div>
                        <div class="full__content">
                        @foreach($categories as $category_id => $category)
                            <p>{{ $category }}: {{ Post::where('publication',1)->where('in_section',1)->where('category_id',$category_id)->count() }}</p>
                        @endforeach
                        </div>
                        @if($posts->count())
                            @include(Helper::acclayout('assets.posts-table'),compact('posts'))
                            {{ $posts->links() }}
                        @else
                            <p>Нет опубликованных постов</p>
                        @endif
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