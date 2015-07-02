<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
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
                        <div class="left-content">
                    @foreach(Dic::where('slug','cooperation_brands')->first()->values as $cooperation)
                        @if(in_array($cooperation->id, $monetization['cooperation']))
                            {{ $cooperation->name }}
                        @endif
                    @endforeach
                        </div>
                    </div>
                    <div class="reg-content__right">

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