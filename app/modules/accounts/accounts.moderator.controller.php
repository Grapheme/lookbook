<?php

class AccountsModeratorController extends BaseController {

    public static $name = 'moderator';
    public static $group = 'accounts';
    public static $entity = 'moderator';
    public static $entity_name = 'Кабинет модератор';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;

        if (Auth::check() && Auth::user()->group_id == 3):
            Route::group(array('before' => 'auth.status.moderator', 'prefix' => self::$name), function() use ($class) {
                Route::get('posts',array('as'=>'moderator.posts','uses'=>$class.'@postsList'));
                Route::post('posts/{post_id}/publication',array('before'=>'csrf', 'as'=>'moderator.posts.publication','uses'=>$class.'@postPublication'));
                Route::get('accounts',array('as'=>'moderator.accounts','uses'=>$class.'@accountsList'));
                Route::post('accounts/{account_id}/save',array('as'=>'moderator.accounts.save','uses'=>$class.'@accountSave'));

                Route::get('profile', array('as' => 'profile', 'uses' => $class . '@profile'));
                Route::put('profile', array('before'=>'csrf', 'as' => 'profile.update', 'uses' => $class . '@profileUpdate'));
                Route::put('profile/password', array('before'=>'csrf', 'as' => 'profile.password.update', 'uses' => 'AccountsBloggerController@profilePasswordUpdate'));
                Route::post('profile/avatar/upload', array('before'=>'csrf', 'as' => 'profile.avatar.upload', 'uses' => 'AccountsBloggerController@profileAvatarUpdate'));
                Route::delete('profile/avatar/delete', array('before'=>'csrf', 'as' => 'profile.avatar.delete', 'uses' => 'AccountsBloggerController@profileAvatarDelete'));
            });
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
    public function profile(){

        if (Auth::user()->first_login):
            $user = Auth::user();
            $user->first_login = FALSE;
            $user->save();
            $user->touch();
        endif;
        $profile = User::where('id',Auth::user()->id)->first();
        return View::make(Helper::acclayout('profile'),compact('profile'));
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
                $user = Auth::user();
                $user->name = Input::get('name');
                $user->email = Input::get('email');
                $user->phone = Input::get('phone');
                $user->save();
                $user->touch();
                $json_request['responseText'] = Lang::get('interface.DEFAULT.success_save');
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }
    /****************************************************************************/
    public function postsList(){
        $posts = Post::where('publication',1)->orderBy('publication','DESC')->orderBy('publish_at','DESC')->orderBy('id','DESC')
            ->with('user','photo','tags_ids','views','likes','comments')->paginate(Config::get('lookbook.posts_limit'));
        list($categories,$tags) = PostBloggerController::getCategoriesAndTags();
        return View::make(Helper::acclayout('posts'),compact('posts','categories','tags'));
    }

    public function postPublication($post_id){
        if($post = Post::where('id',$post_id)->first()):
            $post->publication = Input::has('publication') ? 1 : 0;
            $post->in_index = Input::has('in_index') ? 1 : 0;
            $post->in_section = Input::has('in_section') ? 1 : 0;
            $post->in_promoted = Input::has('in_promoted') ? 1 : 0;
            if (Input::file('photo')):
                AdminUploadsController::deleteUploadedImageFile($post->promoted_photo_id);
                $post->promoted_photo_id = AdminUploadsController::getUploadedImageFile('photo');
            endif;
            $post->save();
            return Redirect::back()->with('message',Lang::get('interface.DEFAULT.success_save'));
        endif;
        return Redirect::back()->with('message',Lang::get('interface.DEFAULT.fail'));
    }
    /****************************************************************************/
    public function accountsList(){

        $accounts = Accounts::where('group_id',4)->orderBy('created_at','DESC')->with('posts')->paginate(Config::get('lookbook.accounts_limit'));
        return View::make(Helper::acclayout('accounts'),compact('accounts'));
    }

    public function accountSave($account_id){

        if($user = User::where('id',$account_id)->first()):
            $user->active = Input::has('active') ? 1 : 0;
            $user->brand = Input::has('brand') ? 1 : 0;
            $user->save();
            return Redirect::back()->with('message',Lang::get('interface.DEFAULT.success_save'));
        endif;
        return Redirect::back()->with('message',Lang::get('interface.DEFAULT.fail'));
    }
    /****************************************************************************/
}