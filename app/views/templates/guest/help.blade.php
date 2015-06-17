<?
/**
 * TITLE: Помощь
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
                        <div class="help-btn">
                            <a href="{{ pageurl('contacts') }}" class="us-btn blue-hover">Задать свой вопрос</a>
                        </div>
                        <div class="help-block">
                            <div class="block__title">Популярные вопросы</div>
                            <div class="block__ques">
                                {{ $page->block('populyarnye-voprosy') }}
                            </div>
                        </div>
                        <div class="help-block block-mins">
                            <div class="block__title">Разделы</div>
                        @if (count($page->blocks))
                            @foreach ($page->blocks as $block)
                                @if(substr($block->slug,0,15) == 'razdel-pomoshhi')
                                <div class="block__ques">
                                    <div class="ques__title">{{ $block->name }}</div>
                                    {{ $page->block($block->slug) }}
                                </div>
                                @endif
                            @endforeach
                        @endif
                            </div>
                        </div>
                    </div>
                    <div class="reg-content__right right-links">
                        <div class="right-title">
                            <a href="{{ pageurl('about') }}">О проекте</a>
                        </div>
                        <div class="right-title">
                            <a href="{{ pageurl('help') }}" class="active">Помощь</a>
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