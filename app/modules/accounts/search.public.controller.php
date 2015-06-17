<?php

class SearchPublicController extends BaseController {

    public static $name = 'search';
    public static $group = 'public';

    /****************************************************************************/
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::post('search', array('before' => 'csrf', 'as' => 'search.public.request',
            'uses' => $class . '@searchRequest'));
    }

    public static function returnShortCodes() {
        return NULL;
    }

    public static function returnActions() {
        return NULL;
    }

    public static function returnInfo() {
        return NULL;
    }

    public static function returnMenu() {
        return NULL;
    }

    /****************************************************************************/
    public function __construct() {}
    /****************************************************************************/
    /****************************************************************************/
    public static function searchRequest() {

        return Redirect::to(pageurl('search'))->with('search_text',Input::get('search_text'));
    }

    /****************************************************************************/
}