<?php

class SearchPublicController extends BaseController {

    public static $name = 'search';
    public static $group = 'public';

    /****************************************************************************/
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::post('search', array('before' => 'csrf', 'as' => 'search.public.request',
            'uses' => $class . '@searchRequest'));
        Route::post('more/posts/search', array('before' => 'csrf', 'as' => 'post.public.more.search',
            'uses' => $class . '@moreSearchPosts'));
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

    public function moreSearchPosts(){

        $json_request = array('status' => FALSE, 'html' => '', 'from' => 0, 'hide_button' => TRUE);
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), array('limit' => 'required', 'from' => 'required',
                'search' => 'required'));
            if ($validator->passes()):
                $posts = array();
                $post_from = Input::get('from');
                $post_limit = Input::get('limit');

                $posts_total = SearchPublicController::getResult(Input::get('search'));
                $posts_total_count = count($posts_total);
                $posts = SearchPublicController::getResult(Input::get('search'), $post_limit, $post_from);

                if (count($posts)):
                    $json_request['html'] = View::make(Helper::layout('blocks.posts-search'), compact('posts'))->render();
                    $json_request['status'] = TRUE;
                    $json_request['from'] = $post_from + $post_limit;
                    $json_request['hide_button'] = $posts_total_count > ($post_from + $post_limit) ? FALSE : TRUE;
                endif;
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request, 200);
    }

    /****************************************************************************/
    public static function getResult($search_text, $limit = 2147483647, $offset = 0){

        return SphinxSearch::search($search_text, 'postsIndexLookBook')
            ->setFieldWeights(array('content' => 10, 'title' => 5))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit($limit, $offset)
            ->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')
            ->get();
    }

    public static function resultBuildExcerpts($searched, $search_string){

        if (count($searched)):
            $docs = array();
            foreach ($searched as $search_model):
                $line = Helper::multiSpace(strip_tags($search_model->content));
                $docs[$search_model->id] = trim($line);
            endforeach;
            return Helper::buildExcerpts($docs, 'postsIndexLookBook', $search_string, array('before_match' => '<mark>', 'after_match' => '</mark>'));
        else:
            return array();
        endif;
    }
}