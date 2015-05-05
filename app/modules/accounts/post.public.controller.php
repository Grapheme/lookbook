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

    public static function indexPage(){

        $post_limit = Config::get('lookbook.posts_limit');
        $categories = $tags = array();
        foreach(Dic::where('slug','categories')->first()->values as $category):
            $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
        endforeach;
        $posts_total_count = Post::where('in_index',1)->where('publication',1)->count();
        $posts = Post::where('in_index',1)->where('publication',1)->with('user','photo','tags_ids','views','likes','comments')->take($post_limit)->get();
        $promoted_posts = Post::where('in_index',1)->where('publication',1)->where('in_promoted',1)->with('user','photo','tags_ids','views','likes','comments')->get();
        return array(
            'post_limit' => $post_limit, 'post_access' => FALSE, 'posts_total_count' => $posts_total_count,
            'tags' => $tags, 'posts' => $posts, 'promoted_posts' => $promoted_posts, 'categories' => $categories
        );
    }

    public static function sectionCategory($page_slug){

        $post_limit = Config::get('lookbook.posts_limit');
        $tags = $categories = array();
        foreach(Dic::where('slug','categories')->first()->values as $category):
            $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
        endforeach;
        if ($category_id = Dic::where('slug','categories')->first()->value()->where('slug',$page_slug)->pluck('id')):
            $posts_total_count = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->count();
            $posts = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->with('user','photo','tags_ids','views','likes','comments')->take($post_limit)->get();
            $promoted_posts = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->where('in_promoted',1)->with('user','photo','tags_ids','views','likes','comments')->get();
            if (isset($tags_lists[$category_id]['category_tags'])):
                $tags = $tags_lists[$category_id]['category_tags'];
            endif;
            return array(
                'post_limit' => $post_limit,'post_access' => FALSE,'posts_total_count' => $posts_total_count,
                'tags' => $tags,'posts' => $posts,'promoted_posts' => $promoted_posts,'category_id'=>$category_id,
                'categories' => $categories
            );
        else:
            return FALSE;
        endif;
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
            $validator = Validator::make(Input::all(),array('publication'=>'required','limit'=>'required','from'=>'required','category'=>'','tag'=>'','user'=>''));
            if($validator->passes()):
                $user_id = Input::get('user');
                $category_id = Input::get('category');
                $post_from = Input::get('from');
                $post_limit = Input::get('limit');
                $post_publication = Input::get('publication') == 'all' ? array(0,1) : array(1);
                $post_access = FALSE;
                if (!$user_id):
                    if (!$category_id):
                        $posts_total_count = Post::where('publication',1)->where('in_index',1)->count();
                        $posts = Post::where('publication',1)->where('in_index',1)->with('user','photo','tags_ids','views','likes','comments')->skip($post_from)->take($post_limit)->get();
                    else:
                        $posts_total_count = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->count();
                        $posts = Post::where('category_id',$category_id)->where('publication',1)->where('in_section',1)->with('user','photo','tags_ids','views','likes','comments')->skip($post_from)->take($post_limit)->get();
                    endif;
                else:
                    if (Auth::check() && Input::get('publication') == 'all'):
                        $post_access = TRUE;
                    endif;
                    if (!$category_id):
                        $posts_total_count = Post::whereIn('publication',$post_publication)->where('user_id',$user_id)->count();
                        $posts = Post::whereIn('publication',$post_publication)->where('user_id',$user_id)->orderBy('publication','ASC')->orderBy('publish_at','DESC')->orderBy('id','DESC')->with('user','photo','tags_ids','views','likes','comments')->skip($post_from)->take($post_limit)->get();
                    else:
                        $posts_total_count = Post::where('category_id',$category_id)->whereIn('publication',$post_publication)->where('user_id',$user_id)->count();
                        $posts = Post::where('category_id',$category_id)->whereIn('publication',$post_publication)->where('user_id',$user_id)->orderBy('publication','ASC')->orderBy('publish_at','DESC')->orderBy('id','DESC')->with('user','photo','tags_ids','views','likes','comments')->skip($post_from)->take($post_limit)->get();
                    endif;
                endif;
                if (count($posts)):
                    $categories = array();
                    foreach(Dic::where('slug','categories')->first()->values as $category):
                        $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
                    endforeach;
                    $json_request['html'] = View::make(Helper::layout('blocks.posts'),compact('posts','categories','post_access'))->render();
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