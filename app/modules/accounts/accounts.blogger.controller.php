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
                Route::get('profile', array('as' => 'profile', 'uses' => $class . '@profile'));
                Route::put('profile', array('before'=>'csrf', 'as' => 'profile.update', 'uses' => $class . '@profileUpdate'));
                Route::put('profile/password', array('before'=>'csrf', 'as' => 'profile.password.update', 'uses' => $class . '@profilePasswordUpdate'));
                Route::post('profile/avatar/upload', array('before'=>'csrf', 'as' => 'profile.avatar.upload', 'uses' => $class . '@profileAvatarUpdate'));
                Route::delete('profile/avatar/delete', array('before'=>'csrf', 'as' => 'profile.avatar.delete', 'uses' => $class . '@profileAvatarDelete'));

                Route::post('subscribe',array('before'=>'csrf', 'as' => 'user.profile.subscribe', 'uses' => $class . '@profileSubscribe'));
            });
        endif;
        Route::get('profile/{user_url}',array('as'=>'user.profile.show','uses'=>$class.'@guestProfileShow'));
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
            'profile' => User::where('id',Auth::user()->id)->first()
        );
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
            if($uploaded = AdminUploadsController::getUploadedImageManipulationFile('photo')):
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
            $user->inspiration = $post['inspiration'];
            $user->phone = $post['phone'];
            $user->blogname = $post['blogname'];
            if ($user->brand):
                $user->blogpicture = AdminUploadsController::getUploadedFile();
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
    /****************************************************************************/

    public function guestProfileShow($user_url){

        $post_limit = Config::get('lookbook.posts_limit');
        $post_access = FALSE;
        $interesting_bloggers = $categories = array();
        foreach(Dic::where('slug','categories')->first()->values as $category):
            $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
        endforeach;
        if ($user = Accounts::where('id',(int)$user_url)->where('active',TRUE)->with('posts.comments','posts.likes','posts.views','posts.photo','posts.tags_ids')->first()):
            $total_views_count = 0;
            foreach(Post::where('user_id',$user->id)->where('publication',1)->with('views')->get() as $posts):
                if(count($posts->views)):
                    $total_views_count += count($posts->views);
                endif;
            endforeach;
            if ($user->brand):
                return View::make(Helper::layout('brand-profile'),compact('user','interesting_bloggers','total_views_count'));
            else:
                return View::make(Helper::layout('blogger-profile'),compact('user','interesting_bloggers','total_views_count'));
            endif;
        endif;
    }

    public function profileSubscribe(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax() && Auth::check() && Auth::user()->group_id == 4):
            $validator = Validator::make(Input::all(),array('user_id'=>'required'));
            if($validator->passes()):
                if (Auth::user()->id != Input::get('user_id') && User::where('id',Input::get('user_id'))->exists()):
                    $blogger_id = Input::get('user_id');
                    Accounts::where('id', Auth::user()->id)->first()->blogger_subscribes()->sync(array($blogger_id => array('created_at' => date('c'),
                        'updated_at' => date('c'))));
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.success_insert');
                    $json_request['status'] = TRUE;
                    return Response::json($json_request,200);
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