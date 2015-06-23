<?php
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
$post_access = FALSE;
$post_limit = Config::get('lookbook.posts_limit');
?>

@section('title'){{ $user->name }}@stop
@section('description')@stop
@section('keywords')@stop

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
                @include(Helper::layout('assets.blogger_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                    @if($posts->count())
                        <ul class="dashboard-list js-posts">
                            @include(Helper::layout('blocks.posts'),compact('posts','categories','post_access'))
                        </ul>
                        @if($posts_total_count > count($posts))
                            @include(Helper::layout('assets.more_post'),array('user'=>$user->id))
                        @endif
                    @endif
                    </div>
                    <div class="reg-content__right">
                        @include(Helper::layout('blocks.top_user_posts'),array('user_id'=>$user->id,'user_name'=>$user->name))
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