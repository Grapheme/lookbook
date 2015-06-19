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
    public static function getResult($search_text){

        return SphinxSearch::search($search_text, 'postsIndexLookBook')
            ->setFieldWeights(array('content' => 10, 'title' => 5))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit(Config::get('lookbook.posts_limit'), 0)
            ->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')
            ->get();
    }
}