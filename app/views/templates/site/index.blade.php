<?
/**
 * TITLE: Главная страница
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())
@section('style')
@stop
@section('page_class')
animsition
@stop
@section('content')
    @include(Helper::layout('block-contacts'))
    <div class="main-wrapper">
        <div class="main-screen">
            <div class="text-layer">
                <div class="js-text item item-1"></div>
                <div class="js-text item item-2"></div>
                <div class="js-text item item-3"></div>
                <div class="js-text item item-4"></div>
                <div class="js-text item item-5"></div>
            </div>
            <div class="images-layer">
                <div class="js-image item item-1"></div>
                <div class="js-image item item-2"></div>
                <div class="js-image item item-3"></div>
                <div class="js-image item item-4"></div>
                <div class="js-image item item-5"></div>
            </div>
            <div class="gradient-layer">
                <div class="gradient-item"></div>
            </div>
            <div class="info-layer">
                @include(Helper::layout('header'),array('header_class'=>'header-white '))
                <div class="main-abs-info">
                    <div class="wrapper">
                        <div class="main-info">
                            <div class="title">{{ $page->block('div_title') }}</div>
                            <div class="desc">{{ $page->block('div_desc') }}</div>
                            <div class="btn-cont">
                                <a href="{{ URL::route('page','portfolio') }}" class="us-btn">{{ $page->block('portfolio_link') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @include(Helper::layout('footer'),array('footer_class'=>'footer-white '))
            </div>
        </div>
    </div>
@stop
@section('scripts')
@stop