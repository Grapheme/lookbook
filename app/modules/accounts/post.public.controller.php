<?php

class PostPublicController extends BaseController {

    public static $name = 'post';
    public static $group = 'public';
    public static $entity = 'post';
    public static $entity_name = 'Пост';

    /****************************************************************************/
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        if (in_array(Request::segment(1), array('admin')) === FALSE):
            Route::get('{category_title}/{post_url}', array('as' => 'post.public.show', 'uses' => $class . '@show'));
        endif;
        Route::post('more/posts', array('before' => 'csrf', 'as' => 'post.public.more',
            'uses' => $class . '@morePosts'));
        Route::post('more/posts/subscribes', array('before' => 'csrf', 'as' => 'post.public.more.subscribes',
            'uses' => $class . '@moreSubscribesPosts'));
        if (Auth::check()):
            Route::post('post/send-comment', array('before' => 'csrf', 'as' => 'post.public.comment.insert',
                'uses' => $class . '@sendComment'));
            Route::delete('post/delete-comment/{comment_id}', array('before' => 'csrf', 'as' => 'post.public.comment.destroy',
                'uses' => $class . '@destroyComment'));
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
    public function __construct() {

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
    public static function indexPage() {

        $post_limit = Config::get('lookbook.posts_limit');
        $categories = $tags = array();
        foreach (Dic::where('slug', 'categories')->first()->values as $category):
            $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
        endforeach;
        $posts_total_count = Post::where('in_index', 1)->where('in_advertising', 0)->where('publication', 1)->count();
        $posts = Post::where('in_index', 1)->where('in_advertising', 0)->where('publication', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->take($post_limit)->get();
        $promoted_posts = Post::where('in_index', 1)->where('publication', 1)->where('in_promoted', 1)->with('user', 'photo', 'promoted_photo', 'tags_ids', 'views', 'likes', 'comments')->get();
        $advertising_posts = Post::where('publication', 1)->where('in_advertising', 1)->where('in_index', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip(0)->take(1)->get();
        $promo_posts = PostPromo::where('position', 0)->where('in_index', 1)->orderBy('order')->with('photo')->get();
        return array(
            'post_limit' => $post_limit, 'post_access' => FALSE, 'posts_total_count' => $posts_total_count,
            'tags' => $tags, 'posts' => $posts, 'advertising_posts' => $advertising_posts, 'promoted_posts' => $promoted_posts, 'promo_posts' => $promo_posts, 'categories' => $categories
        );
    }

    public static function sectionCategory($page_slug) {

        $post_limit = Config::get('lookbook.posts_limit');
        $tags = $categories = array();
        foreach (Dic::where('slug', 'categories')->first()->values as $category):
            $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
        endforeach;
        if ($category_id = Dic::where('slug', 'categories')->first()->value()->where('slug', $page_slug)->pluck('id')):
            $posts_total_count = Post::where('category_id', $category_id)->where('publication', 1)->where('in_section', 1)->count();
            $posts = Post::where('category_id', $category_id)->where('publication', 1)->where('in_section', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->take($post_limit)->get();
            $promoted_posts = Post::where('category_id', $category_id)->where('publication', 1)->where('in_section', 1)->where('in_promoted', 1)->with('user', 'photo', 'promoted_photo', 'tags_ids', 'views', 'likes', 'comments')->get();
            $advertising_posts = Post::where('category_id', $category_id)->where('publication', 1)->where('in_advertising', 1)->where('in_section', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip(0)->take(1)->get();
            $promo_posts = PostPromo::where('position', 0)->where('in_section', 1)->orderBy('order')->with('photo')->get();
            if (isset($tags_lists[$category_id]['category_tags'])):
                $tags = $tags_lists[$category_id]['category_tags'];
            endif;
            return array(
                'post_limit' => $post_limit, 'post_access' => FALSE, 'posts_total_count' => $posts_total_count,
                'tags' => $tags, 'posts' => $posts, 'promoted_posts' => $promoted_posts, 'category_id' => $category_id,
                'categories' => $categories, 'advertising_posts' => $advertising_posts, 'promo_posts' => $promo_posts
            );
        else:
            return FALSE;
        endif;
    }
    /****************************************************************************/
    public function sendComment(){

        $json_request = array('status' => FALSE, 'html' => '');
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), PostComments::$rules);
            if ($validator->passes()):
                $comment = new PostComments();
                $comment->post_id = Input::get('post_id');
                $comment->rating = Input::get('rating');
                $comment->content = Input::get('content');
                $comment->user_id = Auth::user()->id;
                $comment->save();
                $comment->touch();
                $json_request['html'] = View::make(Helper::layout('blocks.comments'), array('comments'=>array($comment)))->render();
                $json_request['status'] = TRUE;
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request, 200);
    }

    public function destroyComment($comment_id){

        $json_request = array('status' => FALSE);
        if (Request::ajax()):
            if (PostComments::where('id', $comment_id)->where('user_id', Auth::user()->id)->delete()):
                $json_request['status'] = TRUE;
            endif;
            if (Auth::user()->group_id == 3):
                PostComments::where('id', $comment_id)->delete();
                $json_request['status'] = TRUE;
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request, 200);
    }
    /****************************************************************************/
    public function show($category_title, $post_title) {

        if ($post = Post::where('id', (int)$post_title)->where('category_id', (int)$category_title)->with('user', 'tags_ids', 'comments', 'likes', 'views', 'photo', 'gallery.photos')->first()):
            list($categories, $tags) = PostBloggerController::getCategoriesAndTags();
            if (isset($categories[$post->category_id])):
                $post->category_title = $categories[$post->category_id];
            endif;
            if ($post->tags_ids->count()):
                $tagsIDs = array();
                foreach ($post->tags_ids as $tag):
                    $tagsIDs[] = $tag->tag_id;
                endforeach;
                if (count($tagsIDs)):
                    $post->tags = PostBloggerController::getTags(array(), $tagsIDs, $tags, $post->category_id);
                endif;
            endif;
            self::incrementViewPost($post);
            return View::make(Helper::layout('post'), compact('post', 'categories', 'tags'));
        else:
            App::abort(404);
        endif;
    }

    public function morePosts() {

        $json_request = array('status' => FALSE, 'html' => '', 'from' => 0, 'hide_button' => TRUE);
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), array('publication' => 'required', 'limit' => 'required',
                'from' => 'required', 'category' => '', 'tag' => '', 'user' => ''));
            if ($validator->passes()):
                $user_id = Input::get('user');
                $category_id = Input::get('category');
                $post_from = Input::get('from');
                $post_limit = Input::get('limit');
                $post_publication = Input::get('publication') == 'all' ? array(0, 1) : array(1);
                $post_access = FALSE;
                $posts = $advertising_posts = $promo_posts = array();
                if (!$user_id):
                    $advertising_post_from  = round($post_from / $post_limit, 0);
                    if (!$category_id):
                        $posts_total_count = Post::where('publication', 1)->where('in_advertising', 0)->where('in_index', 1)->count();
                        $posts = Post::where('publication', 1)->where('in_advertising', 0)->where('in_index', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($post_from)->take($post_limit)->get();
                        $advertising_posts = Post::where('publication', 1)->where('in_advertising', 1)->where('in_index', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($advertising_post_from)->take(1)->get();
                        $promo_posts = PostPromo::where('position', $advertising_post_from)->where('in_index', 1)->orderBy('order')->with('photo')->get();
                    else:
                        $posts_total_count = Post::where('category_id', $category_id)->where('publication', 1)->where('in_section', 1)->count();
                        $posts = Post::where('category_id', $category_id)->where('publication', 1)->where('in_section', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($post_from)->take($post_limit)->get();
                        $advertising_posts = Post::where('category_id', $category_id)->where('publication', 1)->where('in_advertising', 1)->where('in_section', 1)->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($advertising_post_from)->take(1)->get();
                        $promo_posts = PostPromo::where('position', $advertising_post_from)->where('in_section', 1)->orderBy('order')->with('photo')->get();
                    endif;
                else:
                    if (Auth::check() && Input::get('publication') == 'all'):
                        $post_access = TRUE;
                    endif;
                    if (!$category_id):
                        $posts_total_count = Post::whereIn('publication', $post_publication)->where('user_id', $user_id)->count();
                        $posts = Post::whereIn('publication', $post_publication)->where('user_id', $user_id)->orderBy('publication', 'ASC')->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($post_from)->take($post_limit)->get();
                    else:
                        $posts_total_count = Post::where('category_id', $category_id)->whereIn('publication', $post_publication)->where('user_id', $user_id)->count();
                        $posts = Post::where('category_id', $category_id)->whereIn('publication', $post_publication)->where('user_id', $user_id)->orderBy('publication', 'ASC')->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($post_from)->take($post_limit)->get();
                    endif;
                endif;
                if (count($posts)):
                    $json_request['html'] = View::make(Helper::layout('blocks.posts'), compact('posts'))->render();
                    if(count($advertising_posts)):
                        $json_request['html'] .= View::make(Helper::layout('blocks.posts-advertising'), array('posts'=>$advertising_posts))->render();
                    endif;
                    if(count($promo_posts)):
                        $json_request['html'] .= View::make(Helper::layout('blocks.posts-promo'), array('posts'=>$promo_posts))->render();
                    endif;
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

    public function moreSubscribesPosts() {

        $json_request = array('status' => FALSE, 'html' => '', 'from' => 0, 'hide_button' => TRUE);
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), array('publication' => 'required', 'limit' => 'required',
                'from' => 'required', 'category' => '', 'tag' => '', 'user' => ''));
            if ($validator->passes()):
                $posts = array();
                $post_from = Input::get('from');
                $post_limit = Input::get('limit');
                if ($blogsIDs = BloggerSubscribe::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->lists('blogger_id')):
                    $posts_total_count = Post::whereIn('user_id', $blogsIDs)->where('in_advertising', 0)->count();
                    $posts = Post::whereIn('user_id', $blogsIDs)->where('in_advertising', 0)->where('publication', 1)->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($post_from)->take($post_limit)->get();
                    $advertising_post_from  = round($post_from / $post_limit, 0);
                    $advertising_posts = Post::where('publication', 1)->where('in_advertising', 1)->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->skip($advertising_post_from)->take(1)->get();
                    $promo_posts = PostPromo::where('position', $advertising_post_from)->where('in_line', 1)->orderBy('order')->with('photo')->get();
                endif;
                if (count($posts)):
                    $categories = array();
                    foreach (Dic::where('slug', 'categories')->first()->values as $category):
                        $categories[$category->id] = array('slug' => $category->slug, 'title' => $category->name);
                    endforeach;
                    $json_request['html'] = View::make(Helper::layout('blocks.posts'), compact('posts', 'categories'))->render();
                    if(count($advertising_posts)):
                        $json_request['html'] .= View::make(Helper::layout('blocks.posts-advertising'), array('posts'=>$advertising_posts))->render();
                    endif;
                    if(count($promo_posts)):
                        $json_request['html'] .= View::make(Helper::layout('blocks.posts-promo'), array('posts'=>$promo_posts))->render();
                    endif;
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

    private function incrementViewPost($post) {

        if (Auth::check()):
            if (in_array(Auth::user()->group_id, array(3, 4)) !== FALSE && Auth::user()->id != $post->user_id):
                if (PostViews::where('post_id', $post->id)->where('user_id', Auth::user()->id)->exists() === FALSE):
                    PostViews::create(array('post_id' => $post->id, 'user_id' => Auth::user()->id));
                    return TRUE;
                endif;
            endif;
        endif;
        return FALSE;
    }
}