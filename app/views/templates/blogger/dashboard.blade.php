<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::acclayout())
@section('style')
@stop
@section('page_class')
@stop
@section('content')
    <div class="wrapper">
        <div class="container_12">
            <div class="grid_12">
                @include(Helper::acclayout('assets.user_header'))
            </div>
            <div class="clearfix"></div>
            <div class="grid_12 reg-content">
                <div class="dashboard-tab">
                    <div class="reg-content__left">
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__desc">У вас еще нет ни одной записи в блоге. Быстрее исправьте
                                положение.
                            </div>
                            <a href="#" class="white-black-btn">Создать новый пост</a>
                        </div>
                    </div>
                    <div class="reg-content__right">
                        <div class="right-title">БЛОГИ РЕКОМЕНДОВАННЫЕ LOOKBOOK</div>
                        <div class="right-content">У вас еще нет рекомендованных блогов.</div>
                        <div class="right-title">МОЙ БЛОГ-ЛИСТ</div>
                        <div class="right-content">Вы еще не добавили ни один блог в свой блог-лист.<br>Читайте <a
                                    href="#">TOP POST</a> и выбирайте любимые.
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