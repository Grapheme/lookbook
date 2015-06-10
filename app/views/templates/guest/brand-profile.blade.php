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
                @include(Helper::layout('assets.brand_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <div class="left-content">
                            {{ $user->about }}
                        </div>
                        <ul class="left-content-list">
                        @if(!empty($user->inspiration))
                            <li class="list__item">
                                <div class="item__title">Специализация</div>
                                <div class="item__text">{{ $user->inspiration }}</div>
                            </li>
                        @endif
                        @if(!empty($user->site))
                            <li class="list__item">
                                <div class="item__title">Веб-сайт</div>
                                <div class="item__text"><a href="{{ $user->site }}">{{ $user->site }}</a></div>
                            </li>
                        @endif
                        @if(!empty($user->location))
                            <li class="list__item">
                                <div class="item__title">ГОЛОВНОЙ ОФИС</div>
                                <div class="item__text">{{ $user->location }}</div>
                            </li>
                        @endif
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="reg-content__right">
                        <div class="right-content bottom-border">
                            <div class="content__us-text">Блог зарегистрирован {{ (new myDateTime())->setDateString($user->created_at)->months() }}</div>
                            <div class="content__us-text">
                                <i class="svg-icon icon-eye us-icon"></i>{{ $total_views_count }}
                            </div>
                        </div>
                        <div class="right-content bottom-border">
                            <div class="right-btn-cont">
                                <a href="{{ URL::route('user.posts.show', $user->id.'-'.BaseController::stringTranslite($user->name)) }}" class="white-black-btn">Все посты бренда</a>
                            </div>
                        @if(Auth::check() && Auth::user()->group_id == 4 && Auth::user()->id != $user->id)
                            @if(BloggerSubscribe::where('user_id',Auth::user()->id)->where('blogger_id',$user->id)->exists())
                            <div class="right-btn-cont">
                                {{ Form::button('Добавлено в мой блог лист',array('class'=>'white-black-btn','disabled'=>'disabled')) }}
                            </div>
                            @else
                                {{ Form::open(array('route'=>'user.profile.subscribe','method'=>'post','class'=>'right-btn-cont js-action-btn')) }}
                                {{ Form::hidden('user_id',$user->id) }}
                                {{ Form::button('Добавить в мой блог лист',array('class'=>'white-black-btn','type'=>'submit')) }}
                                {{ Form::close() }}
                            @endif
                        @endif
                        </div>
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