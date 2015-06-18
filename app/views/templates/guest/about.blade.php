<?
/**
 * TITLE: О проекте
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())
@section('style')
@stop
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                <div class="category-header header-lite">
                    <div class="header__title">{{ $page->seo->h1 }}</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content border-none">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <div class="reg-text">
                            {{ $page->block('content') }}
                        </div>
                    </div>
                    <div class="reg-content__right right-links">
                        <div class="right-title">
                            <a href="{{ pageurl('about') }}" class="active">О проекте</a>
                        </div>
                        <div class="right-title">
                            <a href="{{ pageurl('help') }}">Помощь</a>
                        </div>
                        <div class="right-title">
                            <a href="{{ pageurl('contacts') }}">Связаться с нами</a>
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