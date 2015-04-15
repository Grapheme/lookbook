<?
/**
 * TITLE: Пост
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
        <div class="container_12 one-post-cont">
            <div class="grid_12">
                <div class="post__header">
                    <div class="header__date">{{ (new myDateTime())->setDateString($post->publish_at.' 00:00:00')->custom_format('M d, Y') }}</div>
                    <div class="header__title">{{ $post->title }}</div>
                    @if(isset($categories[$post->category_id]))
                    <div class="header__subject">
                        <a href="{{ pageurl(BaseController::stringTranslite($categories[$post->category_id])) }}">{{ $categories[$post->category_id] }}</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="reg-content__left">
                    <ul class="dashboard-list one-post js-posts">
                    <?php
                        $hasAvatar = $hasImage = FALSE;
                        if(!empty($post->user->photo) && File::exists(public_path($post->user->photo))):
                            $hasAvatar = TRUE;
                        endif;
                        if(!empty($post->photo) && File::exists(Config::get('site.galleries_photo_dir').'/'.$post->photo->name)):
                            $hasImage = TRUE;
                        endif;
                    ?>
                        <li class="dashboard-item js-post">
                            <div class="left-block">
                                <div data-empty-name="{{ $post->user->name }}" class="profile-ava ava-min{{ !$hasAvatar ? ' ava-empty ' : '' }}">
                                    @if($hasAvatar)
                                        <img src="{{ asset($post->user->photo) }}">
                                    @endif
                                    <div class="ava-image__empty"><span class="js-empty-chars"></span></div>
                                </div>
                                <div class="profile-name">{{ $post->user->name }}</div>
                            </div>
                            <div class="right-block">
                                <div class="right-block__pad">
                                    <div class="post-photo photo-hover-parent">
                                    @if($hasImage)
                                        <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$post->photo->name) }}" alt="{{ $post->title }}">
                                    @endif
                                    @if(!empty($post->photo_title))
                                        <div class="photo-hover"><span>{{ $post->photo_title }}</span></div>
                                    @endif
                                    </div>
                                    <div class="post-info">
                                        <div class="post-info__desc">
                                            {{ $post->content }}
                                        </div>
                                    @if(isset($post->gallery->photos) && count($post->gallery->photos))
                                        <div class="post-info__gallery">
                                        @foreach($post->gallery->photos as $photo)
                                            @if(!empty($photo->name) && File::exists(Config::get('site.galleries_photo_dir').'/'.$photo->name))
                                            <img src="{{ asset(Config::get('site.galleries_photo_public_dir').'/'.$photo->name) }}" alt="{{ $post->title }}">
                                            @endif
                                        @endforeach
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <div class="post-actions">
                                    <span class="actions__title">Поделиться</span>
                                    <span class="actions__btns">
                                        <a href="#" class="white-btn action-soc">
                                            <i class="svg-icon icon-facebook"></i>Facebook
                                        </a>
                                        <a href="#" class="white-btn action-soc">
                                            <i class="svg-icon icon-instagram"></i>Instagram
                                        </a>
                                        <a href="#" class="white-btn action-soc">
                                            <i class="svg-icon icon-vk"></i>Вконтакте
                                        </a>
                                        <a href="#" class="white-btn action-soc">
                                            <i class="svg-icon icon-ok"></i>Одноклассники
                                        </a>
                                    </span>
                                </div>
                                <div class="post-comments">
                                    <div class="comments__title">Комментировать</div>
                                    <div class="comments__body"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="reg-content__right">
                    <div class="right-title">TOP POSTS OF CARLO PAZOLINI</div>
                    <div class="right-content">
                        <ul class="right-content__list list-big">
                            <li class="list__item"><a href="#" class="item__photo"><img
                                            src="http://dummyimage.com/120x120/000/fff" alt=""></a>

                                <div class="item__text">
                                    <div class="text__subject"><a href="#">Lifestyle</a></div>
                                    <div class="text__title"><a href="#">Почему американский сэндвичный хлеб хранится в
                                            20 раз дольше, чем российский?</a></div>
                                    <div class="text__author"><a href="#">Antony Granichniy</a></div>
                                    <div class="text__views"><i class="svg-icon icon-eye"></i>3987</div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li class="list__item"><a href="#" class="item__photo"><img
                                            src="http://dummyimage.com/120x120/000/fff" alt=""></a>

                                <div class="item__text">
                                    <div class="text__subject"><a href="#">Lifestyle</a></div>
                                    <div class="text__title"><a href="#">Почему американский сэндвичный хлеб хранится в
                                            20 раз дольше, чем российский?</a></div>
                                    <div class="text__author"><a href="#">Antony Granichniy</a></div>
                                    <div class="text__views"><i class="svg-icon icon-eye"></i>3987</div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li class="list__item"><a href="#" class="item__photo"><img
                                            src="http://dummyimage.com/120x120/000/fff" alt=""></a>

                                <div class="item__text">
                                    <div class="text__subject"><a href="#">Lifestyle</a></div>
                                    <div class="text__title"><a href="#">Почему американский сэндвичный хлеб хранится в
                                            20 раз дольше, чем российский?</a></div>
                                    <div class="text__author"><a href="#">Antony Granichniy</a></div>
                                    <div class="text__views"><i class="svg-icon icon-eye"></i>3987</div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li class="list__item"><a href="#" class="item__photo"><img
                                            src="http://dummyimage.com/120x120/000/fff" alt=""></a>

                                <div class="item__text">
                                    <div class="text__subject"><a href="#">Lifestyle</a></div>
                                    <div class="text__title"><a href="#">Почему американский сэндвичный хлеб хранится в
                                            20 раз дольше, чем российский?</a></div>
                                    <div class="text__author"><a href="#">Antony Granichniy</a></div>
                                    <div class="text__views"><i class="svg-icon icon-eye"></i>3987</div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li class="list__item"><a href="#" class="item__photo"><img
                                            src="http://dummyimage.com/120x120/000/fff" alt=""></a>

                                <div class="item__text">
                                    <div class="text__subject"><a href="#">Lifestyle</a></div>
                                    <div class="text__title"><a href="#">Почему американский сэндвичный хлеб хранится в
                                            20 раз дольше, чем российский?</a></div>
                                    <div class="text__author"><a href="#">Antony Granichniy</a></div>
                                    <div class="text__views"><i class="svg-icon icon-eye"></i>3987</div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="req-content__full">
                    <div class="left-title">Посты по теме</div>
                    <div class="full__content">
                        <ul class="posts-list">
                            <li class="list__item">
                                <div class="item__cont">
                                    <div class="post-photo"><img src="http://dummyimage.com/385x235/000/fff" alt=""><a
                                                href="#" class="post-photo__alt">Lifestyle</a></div>
                                    <div class="item__date"><a href="#">ЯНВ 26, 2015</a></div>
                                    <div class="item__title"><a href="#">САПОГИ ОСЕНИ. ТЕНДЕНЦИИ И ЛУКБУКИ</a></div>
                                    <div class="item__author"><a href="#">
                                            <div class="author__photo">
                                                <div data-empty-name="Анна Антропова"
                                                     class="profile-ava ava-min ava-empty"><img
                                                            src="images/tmp/profile-photo_max.jpg">

                                                    <div class="ava-image__empty"><span class="js-empty-chars"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="author__name">Елена Руденко</div>
                                        </a></div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="item__cont">
                                    <div class="post-photo"><img src="http://dummyimage.com/385x235/000/fff" alt=""><a
                                                href="#" class="post-photo__alt">Lifestyle</a></div>
                                    <div class="item__date"><a href="#">ЯНВ 26, 2015</a></div>
                                    <div class="item__title"><a href="#">САПОГИ ОСЕНИ. ТЕНДЕНЦИИ И ЛУКБУКИ</a></div>
                                    <div class="item__author"><a href="#">
                                            <div class="author__photo">
                                                <div data-empty-name="Анна Антропова"
                                                     class="profile-ava ava-min ava-empty"><img
                                                            src="images/tmp/profile-photo_max.jpg">

                                                    <div class="ava-image__empty"><span class="js-empty-chars"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="author__name">Елена Руденко</div>
                                        </a></div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="item__cont">
                                    <div class="post-photo"><img src="http://dummyimage.com/385x235/000/fff" alt=""><a
                                                href="#" class="post-photo__alt">Lifestyle</a></div>
                                    <div class="item__date"><a href="#">ЯНВ 26, 2015</a></div>
                                    <div class="item__title"><a href="#">САПОГИ ОСЕНИ. ТЕНДЕНЦИИ И ЛУКБУКИ</a></div>
                                    <div class="item__author"><a href="#">
                                            <div class="author__photo">
                                                <div data-empty-name="Анна Антропова"
                                                     class="profile-ava ava-min ava-empty"><img
                                                            src="images/tmp/profile-photo_max.jpg">

                                                    <div class="ava-image__empty"><span class="js-empty-chars"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="author__name">Елена Руденко</div>
                                        </a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop
@section('scripts')
@stop