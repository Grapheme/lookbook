<?php

class PostPublicController extends BaseController {

    public static $name = 'post';
    public static $group = 'public';
    public static $entity = 'post';
    public static $entity_name = 'Пост';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::get('post/{category_id}/{subcategory_id}/{post_url}',array('as'=>'post.public.view','uses'=>$class.'@postView'));
        Route::get('post/{category_id}/{post_url}',array('as'=>'post.public.view','uses'=>$class.'@postView'));
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

    public function postView(){

        if ($post = Post::where('id',(int)$post_id)->where('user_id',Auth::user()->id)->with('tags_ids','comments','photo','gallery.photos')->first()):
            list($categories,$subcategories,$tags) = self::getCategoriesAndTags();
            if (isset($categories[$post->category_id])):
                $post->category_title = $categories[$post->category_id];
            endif;
            if (isset($subcategories[$post->subcategory_id])):
                $post->subcategory_title = $subcategories[$post->subcategory_id]['name'];
            endif;
            if ($post->tags_ids->count()):
                $tagsIDs = array();
                foreach($post->tags_ids as $tag):
                    $tagsIDs[] = $tag->tag_id;
                endforeach;
                if (count($tagsIDs)):
                    $post->tags = self::getTags(array(),$tagsIDs,$tags,$post->category_id,$post->subcategory_id);
                endif;
            endif;
            return View::make(Helper::acclayout('posts.show'),compact('post'));
        else:
            App::abort(404);
        endif;
    }

}