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
                            <p>Carlo Pazolini, a leading global fashion Footwear and Accessories brand, was founded in
                                1990 by Ilya Reznik as a small family business and is registered as a trademark in
                                Italy. Today Carlo Pazolini is a large international corporation with 272 stores
                                worldwide, including flagship locations in Milan (opened in October 2010) and New York
                                (opened in December 2011). Carlo Pazolini Fine Shoes & Accessories embodies a passion
                                for the modern Italian lifestyle expressed through sophisticated design and Italian
                                craftsmanship.</p>

                            <p>From season to season, the brand maintains the level of accessible luxury products,
                                designed with a sense of Italian lifestyle and craftsmanship in mind. Inspired by global
                                fashion trends, the brand’s designers create seasonal collections that offer a wide
                                assortment of «get noticed» styles for everybody who wants to reveal their unique
                                style.</p>

                            <p>Carlo Pazolini continues to expand its presence both in Europe and the US with the first
                                West Coast outpost opened in June 2014 in LA’s Beverly Center.</p>
                        </div>
                        <ul class="left-content-list">
                            <li class="list__item">
                                <div class="item__title">Специализация</div>
                                <div class="item__text">Footwear, Handbags, Accessories</div>
                            </li>
                            <li class="list__item">
                                <div class="item__title">Веб-сайт</div>
                                <div class="item__text"><a href="#">www.carlopazolini.com/en</a></div>
                            </li>
                            <li class="list__item">
                                <div class="item__title">ГОЛОВНОЙ ОФИС</div>
                                <div class="item__text">501 Madison Ave 10th Floor New York, NY 10022 United States
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="reg-content__right">
                        <div class="right-content bottom-border">
                            <div class="content__us-text">Блог зарегистрирован 26 июня 2014 года</div>
                            <div class="content__us-text"><i class="svg-icon icon-eye us-icon"></i>2</div>
                        </div>
                        <div class="right-content bottom-border">
                            <div class="right-btn-cont"><a href="#" class="white-black-btn">Все посты Carlo Pazolini</a>
                            </div>
                            <form action="json/test.json" class="right-btn-cont js-action-btn">
                                <input type="hidden" name="brand_id" value="2">
                                <input type="hidden" name="user_id" value="33">
                                <button type="submit" class="white-black-btn">Добавить в мой блог лист</button>
                            </form>
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