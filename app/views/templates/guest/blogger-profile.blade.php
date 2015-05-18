<?
/*
 * TEMPLATE_IS_NOT_SETTABLE
 */
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
                @include(Helper::layout('assets.user_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <div class="left-content">
                            {{ $user->about }}
                        </div>
                        @if(count($interesting_bloggers))
                        <div class="left-title">Интересный блоги</div>
                        <div class="left-content">
                            <ul class="right-content__list">
                            @foreach($interesting_bloggers as $interesting_blogger)
                                <li class="list__item">
                                    @include(Helper::layout('assets.avatar'),array('user'=>$interesting_blogger))
                                </li>
                            @endforeach
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        @endif
                    </div>
                    <div class="reg-content__right">
                        <div class="right-content bottom-border">
                            <div class="content__us-text">Блог зарегистрирован {{ (new myDateTime())->setDateString($user->created_at)->months() }}</div>
                            <div class="content__us-text">
                                <i class="svg-icon icon-eye us-icon"></i>{{ $total_views_count }}
                            </div>
                        </div>
                        @if(!empty($user->location) && !empty($user->birth))
                        <div class="right-content bottom-border">
                            <div class="content__us-title">О себе</div>
                            <table class="content__us-table">
                                @if(!empty($user->birth))
                                <tr>
                                    <td>Дата рождения</td>
                                    <td>{{ (new myDateTime())->setDateString($user->birth)->months() }}</td>
                                </tr>
                                @endif
                                @if(!empty($user->location))
                                <tr>
                                    <td>Местонахождение</td>
                                    <td>{{ $user->location }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        @endif
                        <div class="right-content bottom-border">
                            <div class="content__us-title">Для связи со мной</div>
                            <div class="content__us-block">
                                <div class="content__us-text">Электронная почта</div>
                                <ul class="block__links">
                                    <li><a href="mailto:{{ $user->email }}" class="us-link">{{ $user->email }}</a></li>
                                </ul>
                            </div>
                            @if(!empty($user->links))
                            <div class="content__us-block">
                                <div class="content__us-text">Мои блоги на сторонних ресурсах</div>
                                <?php $links = explode(',',$user->links);?>
                                <ul class="block__links">
                                @foreach($links as $link)
                                    <li><a href="{{ $link }}" class="us-link">{{ $link }}</a></li>
                                @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(!empty($user->site))
                            <div class="content__us-block">
                                <div class="content__us-text">Мой сайт</div>
                                <ul class="block__links">
                                    <li><a href="{{ $user->site }}" class="us-link">{{ $user->site }}</a></li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        @if(!empty($user->inspiration))
                        <div class="right-content bottom-border">
                            <div class="content__us-block">
                                <div class="content__us-text">Источники вдохновения</div>
                                <div class="block__links">{{ $user->inspiration }}</div>
                            </div>
                        </div>
                        @endif
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