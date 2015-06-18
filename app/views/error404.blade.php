@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <main>
        <div class="slideshow">
            <div class="slide">
                <div class="slide-bg" style="background-image: url({{asset('theme/img/404bg.jpg')}});"></div>
                <section class="slide-cont" style="margin-top: 60px;">
                    <header>
                        <div class="slide-logo" style="background: url({{asset('theme/img/404.png')}}); width: 215px; height: 96px;">
                            
                        </div>
                        <div class="desc"></div>
                    </header>
                    <div class="wrapper">
                        <div class="container_12">
                            <div class="grid_12">
                                <h2 class="slide-head" style="margin-bottom: 0;">
                                    ОШИБКА 404
                                </h2>
                                <div>
                                    Запрашиваемая вами страница не существует.<br>
                                    Вернитесь на <a href="/" class="us-link">главную</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-desc">
                        
                    </div>
                </section>
            </div>
            <div class="arrow arrow-left"><span class="icon icon-angle-left"></span></div>
            <div class="arrow arrow-right"><span class="icon icon-angle-right"></span></div>
        </div>
    </main>

@stop


@section('scripts')
@stop