<?
/**
 * MENU_PLACEMENTS: main_menu=Основное меню
 */
?>
@if (@is_object($seo))
    @section('title'){{ $seo->title }}@stop
    @section('description'){{ $seo->description }}@stop
    @section('keywords'){{ $seo->keywords }}@stop
@elseif (@is_object($page->meta->seo))
    @section('title'){{ $page->meta->seo->title ? $page->meta->seo->title : $page->name }}@stop
    @section('description'){{ $page->meta->seo->description }}@stop
    @section('keywords'){{ $page->meta->seo->keywords }}@stop
@elseif (@is_object($page->meta))
    @section('title'){{{ $page->name }}}@stop
@endif
<!DOCTYPE html>
<html lang="" class="no-js">
<head>
	@include(Helper::layout('head'))
    @yield('style')
</head>
<body class="@yield('page_class')">
    @section('content')
        {{ @$content }}
    @show
    @include(Helper::layout('scripts'))
    @yield('scripts')
</body>
</html>