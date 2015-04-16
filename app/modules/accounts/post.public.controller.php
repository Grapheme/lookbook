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
        Route::post('more/posts',array('before'=>'csrf','as'=>'post.public.more','uses'=>$class.'@more'));
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

    public function more(){

        $json_request = array('status'=>FALSE,'html'=>'','from'=>0,'hide_button'=>TRUE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),array('limit'=>'required','from'=>'required','category'=>'','tag'=>''));
            if($validator->passes()):
                $category_id = Input::get('category');
                $post_from = Input::get('from');
                $post_limit = Input::get('limit');
                if (!$category_id):
                    $posts_total_count = Post::where('publication',1)->where('in_index',1)->count();
                    $posts = Post::where('publication',1)->where('in_index',1)->with('user','photo','tags_ids','views','likes','comments')->skip($post_from)->take($post_limit)->get();
                else:
                    $posts_total_count = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->count();
                    $posts = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->with('user','photo','tags_ids','views','likes','comments')->skip($post_from)->take($post_limit)->get();
                endif;
                if (count($posts)):
                    $categories = array();
                    foreach(Dic::where('slug','categories')->first()->values as $category):
                        $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
                    endforeach;
                    $json_request['html'] = View::make(Helper::layout('blocks.posts'),compact('posts','categories'))->render();
                    $json_request['status'] = TRUE;
                    $json_request['from'] = $post_from+$post_limit;
                    $json_request['hide_button'] = $posts_total_count > ($post_from+$post_limit) ? FALSE : TRUE ;
                endif;
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }
}