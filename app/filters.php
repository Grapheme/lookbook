<?php

App::before(function($request){
    Xss::globalXssClean();
});

App::after(function($request, $response){
	//
});

App::error(function(Exception $exception, $code){

	switch($code):
		case 403:
            return 'Access denied!';
        /*
		case 404:
			#if(Page::where('seo_url','404')->exists()):
			#	return spage::show('404',array('message'=>$exception->getMessage()));
			#else:
			#	return View::make('error404', array('message'=>$exception->getMessage()), 404);
			#endif;
        */
	endswitch;

    if (View::exists(Helper::layout($code)))
        return Response::view(Helper::layout($code), array('message' => $exception->getMessage()), $code);

});

App::missing(function ($exception) {

    $tpl = View::exists(Helper::layout('404')) ? Helper::layout('404') : 'error404';
    return Response::view($tpl, array('message' => $exception->getMessage()), 404);
});

Route::filter('auth', function(){
	if(Auth::guest()):
		App::abort(404);
	endif;
});

Route::filter('login', function(){
	if(Auth::check()):
		return Redirect::to(AuthAccount::getStartPage());
	endif;
});

Route::filter('auth.basic', function(){
	return Auth::basic();
});

Route::filter('admin.auth', function(){

	if(!AuthAccount::isAdminLoggined()):
		return Redirect::to('/');
	endif;
});

Route::filter('auth.status.blogger', function(){

    if(Auth::guest()):
        return Redirect::to('/');
    elseif(Auth::check() && Auth::user()->active == 0):
        Auth::logout();
        return Redirect::to('/');
    endif;
});

Route::filter('auth.status.moderator', function(){

    if(Auth::guest()):
        return Redirect::to('/');
    elseif(Auth::user()->group_id != 3):
        return Redirect::to('/');
    endif;
});

Route::filter('guest.register', function(){
    if(Auth::check()):
        return Redirect::to('/');
    endif;
    if (Session::token() != Input::get('_token')):
        throw new Illuminate\Session\TokenMismatchException;
    endif;
});

/*
|--------------------------------------------------------------------------
| Permission Filter
|--------------------------------------------------------------------------
*/
if(Auth::check()):
	#Allow::modulesFilters();
endif;

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
*/

Route::filter('guest', function(){
	if(Auth::check()):
		return Redirect::to('/');
	endif;
});

Route::filter('auth2login', function(){
    if(Auth::check()) {
        if (Request::path() != AuthAccount::getStartPage())
            return Redirect::to(AuthAccount::getStartPage());
    } else {
        return Redirect::route('login');
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
*/

Route::filter('csrf', function(){
	if (Session::token() != Input::get('_token')):
		throw new Illuminate\Session\TokenMismatchException;
	endif;
});

/*
|--------------------------------------------------------------------------
| Internationalization-in-url filter (I18N)
|--------------------------------------------------------------------------
*/

/*
 * Фильтр используется для переадресации мультиязычных страниц на урл, первым сегментом которого идет указатель на текущий язык, например /ru/{url}.
 * Работает в паре с кодом из /app/start/global.php
 */
Route::filter('i18n_url', function(){

    $locales = Config::get('app.locales');
    if ( @!$locales[Request::segment(1)] ) {
        if (Request::path() != '/') {
            ## Если не главная страница - подставим дефолтную локаль и сделаем редирект
            #Helper::dd(Config::get('app.locale') . '/' . Request::path());
            Redirect(URL::to(Config::get('app.locale') . '/' . Request::path()));
        }
    }
});

function Redirect($url = '', $code = '301 Moved Permanently') {
	header("HTTP/1.1 {$code}");
    header("Location: {$url}");
    die;
}

## Выводит на экран все SQL-запросы
#Event::listen('illuminate.query',function($query){ echo "<pre>" . print_r($query, 1) . "</pre>\n"; });
