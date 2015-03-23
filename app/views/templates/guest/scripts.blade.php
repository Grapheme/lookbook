<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>

@if(Config::get('app.use_scripts_local'))
    {{ HTML::scriptmod('private/js/vendor/jquery.min.js') }}
@else
    {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js") }}
    <script>window.jQuery || document.write('<script src="private/js/vendor/jquery.min.js"><\/script>')</script>
@endif

{{ HTML::scriptmod(Config::get('site.theme_path')."/scripts/vendor.js") }}
{{ HTML::scriptmod(Config::get('site.theme_path')."/scripts/main.js") }}