<?php

class AccountsBloggerController extends BaseController {

    public static $name = 'blogger';
    public static $group = 'accounts';
    public static $entity = 'blogger';
    public static $entity_name = 'Действия блогера';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        if (Auth::check() && Auth::user()->group_id == 4):
            Route::group(array('before' => 'auth.status.blogger', 'prefix' => self::$name), function() use ($class) {
                Route::get('subscribers', array('as' => 'subscribers', 'uses' => $class . '@subscribers'));
                Route::get('blog-list', array('as' => 'blogger-blog-list', 'uses' => $class . '@blogList'));

                Route::get('profile', array('as' => 'profile', 'uses' => $class . '@profile'));
                Route::put('profile', array('before'=>'csrf', 'as' => 'profile.update', 'uses' => $class . '@profileUpdate'));
                Route::put('profile/monetization', array('before'=>'csrf', 'as' => 'blogger.monetization.update', 'uses' => $class . '@profileMonetizationUpdate'));
                Route::put('profile/password', array('before'=>'csrf', 'as' => 'profile.password.update', 'uses' => $class . '@profilePasswordUpdate'));
                Route::post('profile/avatar/upload', array('before'=>'csrf', 'as' => 'profile.avatar.upload', 'uses' => $class . '@profileAvatarUpdate'));
                Route::delete('profile/avatar/delete', array('before'=>'csrf', 'as' => 'profile.avatar.delete', 'uses' => $class . '@profileAvatarDelete'));

                Route::post('subscribe',array('before'=>'csrf', 'as' => 'user.profile.subscribe', 'uses' => $class . '@profileSubscribe'));
                Route::delete('unsubscribe',array('before'=>'csrf', 'as' => 'user.profile.subscribe.destroy', 'uses' => $class . '@profileUnSubscribe'));
            });
        endif;
        Route::get('profile/{user_url}',array('as'=>'user.profile.show','uses'=>$class.'@guestProfileShow'));
        Route::get('profile/{user_url}/posts',array('as'=>'user.posts.show','uses'=>$class.'@guestProfilePostsShow'));

        Route::post('more/blogs', array('before' => 'csrf', 'as' => 'blogs.public.more',
            'uses' => $class . '@moreBlogs'));
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
    public function profile(){

        $page_data = array(
            'page_title'=> Lang::get('seo.BLOGGER.title'),
            'page_description'=> Lang::get('seo.BLOGGER.description'),
            'page_keywords'=> Lang::get('seo.BLOGGER.keywords'),
            'profile' => Accounts::where('id',Auth::user()->id)->first(),
            'monetization' => array('main'=>array(),'cooperation'=>array(),'thrust'=>array())
        );

        if(!Auth::user()->brand):
            $page_data['monetization']['main'] = BloggerMonetization::where('user_id', Auth::user()->id)->first();
            foreach(BloggerCooperationBrands::where('user_id', Auth::user()->id)->get() as $cooperation):
                $page_data['monetization']['cooperation'][] = $cooperation->cooperation_brand_id;
            endforeach;
            foreach(BloggerThrust::where('user_id', Auth::user()->id)->get() as $thrust):
                $page_data['monetization']['thrust'][] = $thrust->thrust_id;
            endforeach;
        endif;
        if (Auth::user()->first_login):
            $user = Auth::user();
            $user->first_login = FALSE;
            $user->save();
            $user->touch();
        endif;
        return View::make(Helper::acclayout('profile'),$page_data);
    }

    public function profileUpdate(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),array('name'=>'required','email'=>'required|email'));
            if (Auth::user()->email != Input::get('email') && User::where('email',Input::get('email'))->exists()):
                $json_request['responseText'] = Lang::get('interface.DEFAULT.email_exist');
                return Response::json($json_request,200);
            endif;
            if($validator->passes()):
                if(self::accountUpdate(Input::all())):
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.success_save');
                    $json_request['status'] = TRUE;
                else:
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.fail');
                endif;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function profileMonetizationUpdate(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),array());
            if($validator->passes()):
                if(self::accountMonetizationUpdate(Input::all())):
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.success_save');
                    $json_request['status'] = TRUE;
                else:
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.fail');
                endif;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function profilePasswordUpdate(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),array('password'=>'required|min:6|confirmed','password_confirmation'=>'required|min:6'));
            if($validator->passes()):
                if(self::accountPasswordUpdate(Input::get('password'))):
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.success_change');
                    $json_request['status'] = TRUE;
                else:
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.fail');
                endif;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function profileAvatarUpdate(){

        $json_request = array('status'=>FALSE,'responseText'=>'','image'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            if($uploaded = AdminUploadsController::createImageInBase64String('photo')):
                $user = Auth::user();
                $user->photo = @$uploaded['main'];
                $user->	thumbnail = @$uploaded['thumb'];
                $user->save();
                $user->touch();
                $json_request['image'] = asset($user->photo);
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = Lang::get('interface.DEFAULT.fail');
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function profileAvatarDelete(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $user = Auth::user();
            if(File::exists(public_path($user->photo))):
                File::delete(public_path($user->photo));
            endif;
            if(File::exists(public_path($user->thumbnail))):
                File::delete(public_path($user->thumbnail));
            endif;
            $user->photo = '';
            $user->	thumbnail = '';
            $user->save();
            $user->touch();
            $json_request['status'] = TRUE;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }
    /****************************************************************************/
    private function accountUpdate($post){

        try {
            $user = Auth::user();
            $user->name = $post['name'];
            $user->surname = '';

            $user->birth = $post['birth'];
            $user->location = $post['location'];
            $user->links = $post['links'];
            $user->site = $post['site'];
            $user->sex = $post['sex'];
            $user->inspiration = $post['inspiration'];
            $user->phone = $post['phone'];
            $user->blogname = $post['blogname'];
            if ($user->brand):
                if($image_path = AdminUploadsController::getUploadedFile('picture')):
                    if (!empty($user->blogpicture) && File::exists(public_path($user->blogpicture))):
                        File::delete(public_path($user->blogpicture));
                    endif;
                    $user->blogpicture = $image_path;
                endif;
            else:
                $user->blogpicture = '';
            endif;
            $user->about = $post['about'];
            $user->save();
            $user->touch();
        }catch (Exception $e){
            return FALSE;
        }
        return TRUE;
    }

    private function accountMonetizationUpdate($post){

        if(!$monetization = BloggerMonetization::where('user_id', Auth::user()->id)->first()):
            $monetization = new BloggerMonetization();
        endif;

        $monetization->user_id = Auth::user()->id;
        $monetization->features = $post['features'];
        $monetization->phone = $post['phone'];
        $monetization->location = $post['location'];

        $monetization->save();
        $monetization->touch();

        if(!isset($post['cooperation_brands'])):
            $post['cooperation_brands'] = array();
        endif;
        if(!isset($post['thrust'])):
            $post['thrust'] = array();
        endif;

        Accounts::where('id', Auth::user()->id)->first()->cooperation_brands()->sync($post['cooperation_brands']);
        Accounts::where('id', Auth::user()->id)->first()->thrust()->sync($post['thrust']);

        return TRUE;
    }

    private function accountPasswordUpdate($password = NULL){

        try{
            if (is_null($password)):
                $password = Str::random(12);
            endif;
            $user = Auth::user();
            $user->password = Hash::make($password);

            $user->save();
            $user->touch();
        }catch (Exception $e){
            return FALSE;
        }
        return TRUE;
    }
    /**************************************************************************/
    public function subscribers(){

        $page_data = array(
            'page_title' => Lang::get('seo.BLOGGER.title'), 'page_description' => Lang::get('seo.BLOGGER.description'),
            'page_keywords' => Lang::get('seo.BLOGGER.keywords'),
            'posts' => array(), 'recommended_blogs' => array(), 'blog_list' => array(), 'categories' => array(),
            'posts_total_count' => 0, 'post_limit' => Config::get('lookbook.posts_limit')
        );
        foreach(Dic::where('slug','categories')->first()->values as $category):
            $page_data['categories'][$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
        endforeach;
        $post_access = FALSE;
        if ($blogsIDs = BloggerSubscribe::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->lists('blogger_id')):
            $page_data['blog_list'] = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->take(5)->get();
            $page_data['posts_total_count'] = Post::whereIn('user_id',$blogsIDs)->count();
            $page_data['posts'] = Post::whereIn('user_id',$blogsIDs)->where('publication',1)->orderBy('publish_at','DESC')->orderBy('id','DESC')->with('user','photo','tags_ids','views','likes','comments')->take($page_data['post_limit'])->get();
        endif;
        return View::make(Helper::acclayout('subscribes-bloggs'),$page_data);
    }

    public function blogList(){

        $page_data = array(
            'page_title' => Lang::get('seo.BLOGGER.title'), 'page_description' => Lang::get('seo.BLOGGER.description'),
            'page_keywords' => Lang::get('seo.BLOGGER.keywords'),
            'blogs' => array(), 'recommended_blogs' => array(), 'blogs_total_count' => 0
        );
        if ($blogsIDs = BloggerSubscribe::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->lists('blogger_id')):
            $page_data['blogs'] = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->take(Config::get('lookbook.blogs_limit'))->with('me_signed')->get();
            $page_data['blogs_total_count'] = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->count();
        endif;
        return View::make(Helper::acclayout('blog-list'),$page_data);
    }
    /****************************************************************************/
    public function moreBlogs() {

        $json_request = array('status' => FALSE, 'html' => '', 'from' => 0, 'hide_button' => TRUE);
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), array('limit' => 'required', 'from' => 'required', 'user' => '', 'brand'=>''));
            if ($validator->passes()):
                $blogs = array();
                $blog_from = Input::get('from');
                $blog_limit = Input::get('limit');
                if(Input::has('user') && Input::get('user') > 0):
                    if ($blogsIDs = BloggerSubscribe::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->lists('blogger_id')):
                        $blogs_total_count = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->count();
                        $blogs = Accounts::where('group_id', 4)->where('active', 1)->whereIn('id', $blogsIDs)->with('me_signed')->skip($blog_from)->take($blog_limit)->get();
                    endif;
                    if (count($blogs)):
                        $json_request['html'] = View::make(Helper::layout('blocks.subscribes.blogs'), compact('blogs'))->render();
                        $json_request['status'] = TRUE;
                        $json_request['from'] = $blog_from + $blog_limit;
                        $json_request['hide_button'] = $blogs_total_count > ($blog_from + $blog_limit) ? FALSE : TRUE;
                    endif;
                else:
                    $blogs_total_count = Accounts::where('group_id', 4)->where('active', 1)->where('brand', Input::get('brand'))->count();
                    if ($blogs = Accounts::where('group_id', 4)->where('active', 1)->where('brand', Input::get('brand'))->with('me_signed')->skip($blog_from)->take($blog_limit)->get()):
                        $json_request['html'] = View::make(Helper::layout('blocks.bloggers'), compact('blogs'))->render();
                        $json_request['status'] = TRUE;
                        $json_request['from'] = $blog_from + $blog_limit;
                        $json_request['hide_button'] = $blogs_total_count > ($blog_from + $blog_limit) ? FALSE : TRUE;
                    endif;
                endif;
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request, 200);
    }
    /****************************************************************************/
    public function guestProfileShow($user_url){

        if ($user = Accounts::where('id',(int)$user_url)->where('active',TRUE)->first()):
            $total_views_count = 0;
            foreach(Post::where('user_id',$user->id)->where('publication',1)->with('views')->get() as $posts):
                if(count($posts->views)):
                    $total_views_count += count($posts->views);
                endif;
            endforeach;
            if ($user->brand):
                return View::make(Helper::layout('brand-profile'),compact('user','interesting_bloggers','total_views_count'));
            else:
                $interesting_bloggers = array();
                return View::make(Helper::layout('blogger-profile'),compact('user','interesting_bloggers','total_views_count'));
            endif;
        endif;
    }

    public function guestProfilePostsShow($user_url){

        if ($user = Accounts::where('id',(int)$user_url)->where('active',TRUE)->first()):
            $post_limit = Config::get('lookbook.posts_limit');
            $posts_total_count = Post::where('user_id', $user->id)->where('publication', 1)->count();
            $posts = Post::where('user_id', $user->id)->orderBy('publication', 'ASC')->orderBy('publish_at', 'DESC')->orderBy('id', 'DESC')->with('user', 'photo', 'tags_ids', 'views', 'likes', 'comments')->take($post_limit)->get();
            if ($user->brand):
                return View::make(Helper::layout('brand-profile-posts'),compact('user','posts','posts_total_count'));
            else:
                return View::make(Helper::layout('blogger-profile-posts'),compact('user','posts','posts_total_count'));
            endif;
        endif;
    }

    public function profileSubscribe(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax() && Auth::check() && Auth::user()->group_id == 4):
            $validator = Validator::make(Input::all(),array('user_id'=>'required'));
            if($validator->passes()):
                if (Auth::user()->id != Input::get('user_id') && User::where('id',Input::get('user_id'))->exists()):
                    if(BloggerSubscribe::where('user_id',Auth::user()->id)->where('blogger_id',Input::get('user_id'))->exists() === FALSE):
                        $subscribe = new BloggerSubscribe();
                        $subscribe->user_id = Auth::user()->id;
                        $subscribe->blogger_id =Input::get('user_id');
                        $subscribe->save();
                        $json_request['responseText'] = Lang::get('interface.DEFAULT.success_insert');
                        $json_request['status'] = TRUE;
                    endif;
                endif;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function profileUnSubscribe(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax() && Auth::check() && Auth::user()->group_id == 4):
            $validator = Validator::make(Input::all(),array('user_id'=>'required'));
            if($validator->passes()):
                if (Auth::user()->id != Input::get('user_id') && User::where('id',Input::get('user_id'))->exists()):
                    if($blog = BloggerSubscribe::where('user_id',Auth::user()->id)->where('blogger_id',Input::get('user_id'))->first()):
                        $blog->delete();
                        $json_request['responseText'] = Lang::get('interface.DEFAULT.success_remove');
                        $json_request['status'] = TRUE;
                    endif;
                endif;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }
}