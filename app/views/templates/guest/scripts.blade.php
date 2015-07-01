<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@if(Config::has('noscripts') && Config::get('noscripts'))

@else
@if(Config::get('app.use_scripts_local'))
    {{ HTML::scriptmod('private/js/vendor/jquery.min.js') }}
@else
    {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js") }}
    <script>window.jQuery || document.write('<script src="private/js/vendor/jquery.min.js"><\/script>')</script>
@endif
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{ HTML::scriptmod(Config::get('site.theme_path')."/scripts/vendor.js") }}
{{ HTML::scriptmod(Config::get('site.theme_path')."/../dev/app/scripts/main.js") }}
{{-- HTML::scriptmod(Config::get('site.theme_path')."/scripts/main.js") --}}
@endif