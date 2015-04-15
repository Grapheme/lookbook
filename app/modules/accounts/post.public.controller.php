<?php

class PostPublicController extends BaseController {

    public static $name = 'post';
    public static $group = 'public';
    public static $entity = 'post';
    public static $entity_name = 'Пост';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        if (in_array(Request::segment(1),array('admin')) === FALSE):
            Route::get('{category_title}/{post_url}',array('as'=>'post.public.show','uses'=>$class.'@show'));
        endif;
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
    public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group,
            'tpl' => static::returnTpl(),
            'gtpl' => static::returnTpl(),
            'class' => __CLASS__,

            'entity' => self::$entity,
            'entity_name' => self::$entity_name,
        );
        View::share('module', $this->module);
    }
    /****************************************************************************/
    /****************************************************************************/

    public function show($category_title,$post_title){

        if ($post = Post::where('id',(int)$post_title)->where('category_id',(int) $category_title)->with('user','tags_ids','comments','likes','views','photo','gallery.photos')->first()):
            list($categories,$tags) = PostBloggerController::getCategoriesAndTags();
            if (isset($categories[$post->category_id])):
                $post->category_title = $categories[$post->category_id];
            endif;
            if ($post->tags_ids->count()):
                $tagsIDs = array();
                foreach($post->tags_ids as $tag):
                    $tagsIDs[] = $tag->tag_id;
                endforeach;
                if (count($tagsIDs)):
                    $post->tags = PostBloggerController::getTags(array(),$tagsIDs,$tags,$post->category_id);
                endif;
            endif;
            return View::make(Helper::layout('post'),compact('post','categories','tags'));
        else:
            App::abort(404);
        endif;
    }

}