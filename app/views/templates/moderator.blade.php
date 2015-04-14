<?
/**
 * MENU_PLACEMENTS: main_menu=Основное меню
 */
?>
@section('title'){{ 'Кабинет модератора'}}@stop
@section('description'){{ '' }}@stop
@section('keywords'){{ '' }}@stop
<!DOCTYPE html>
<html lang="" class="no-js">
    <head>
        @include(Helper::layout('head'))
        @yield('style')
    </head>
    <body class="@yield('page_class')">
        @include(Helper::layout('header'))
        @section('content')
            {{ @$content }}
        @show
        @include(Helper::layout('footer'))
        @include(Helper::layout('scripts'))
        @yield('scripts')
    </body>
</html>