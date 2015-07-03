<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::layout())
@section('style')
    <style>
        .header, .footer {
            display: none;
        }
    </style>
@stop
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12 one-post-cont">
            <div class="grid_12">
                <div class="post__header">
                    <div class="header__date">{{ (new myDateTime())->setDateString($post['publish_at'].' 00:00:00')->custom_format('M d, Y') }}</div>
                    <div class="header__title">{{ $post['title'] }}</div>
                    @if(isset($categories[$post['category_id']]))
                    <div class="header__subject">
                        <a href="javascript:void(0);">{{ $categories[$post['category_id']] }}</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="reg-content__left">
                    <ul class="dashboard-list one-post js-posts">
                    <?php
                        $hasImage = FALSE;
                        if(!empty($post['photo']) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post['photo'])):
                            $hasImage = TRUE;
                        endif;
                    ?>
                        <li class="dashboard-item js-post">
                            <div class="left-block">
                                @include(Helper::layout('assets.avatar'),array('user'=>Auth::user()))
                            </div>
                            <div class="right-block">
                                <div class="right-block__pad">
                                    <div class="post-photo photo-hover-parent">
                                    @if($hasImage)
                                        <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post['photo']) }}" alt="{{ $post['title'] }}">
                                    @endif
                                    @if(!empty($post['photo_title']))
                                        <div class="photo-hover"><span>{{ $post['photo_title'] }}</span></div>
                                    @endif
                                    </div>
                                    <div class="post-info">
                                        <div class="post-info__desc">
                                            {{ $post['content'] }}
                                        </div>
                                    @if(count($post['gallery']))
                                        <div class="post-info__gallery js-gallery">
                                        @foreach($post['gallery'] as $photo_name)
                                            @if(!empty($photo_name) && File::exists(Config::get('site.galleries_photo_dir').'/'.$photo_name))
                                            <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$photo_name) }}" alt="{{ $post['title'] }}">
                                            @endif
                                        @endforeach
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="reg-content__right"></div>
                <div class="clearfix"></div>
                <div class="req-content__full"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop
@section('scripts')
    <!-- {{ HTML::scriptmod(Config::get('site.theme_path')."/scripts/vendor.js") }} -->
    <!-- {{ HTML::scriptmod(Config::get('site.theme_path')."/../dev/app/scripts/main.js") }} -->
@stop