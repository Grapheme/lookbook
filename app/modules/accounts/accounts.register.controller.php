<?php

class AccountsRegisterController extends BaseController {

    public static $name = 'registration';
    public static $group = 'accounts';
    public static $entity = 'registration';
    public static $entity_name = 'Регистрация пользователей';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::group(array('before' => 'guest.register', 'prefix' => ''), function() use ($class) {
            Route::post('registration', array('before' => 'csrf', 'as' => 'signup-blogger', 'uses' => $class . '@signupBlogger'));
        });
        Route::group(array('before' => 'guest.auth', 'prefix' => ''), function() use ($class) {
            Route::get('registration/activation/{activate_code}', array('as' => 'signup-activation', 'uses' => $class . '@activation'));
        });
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

    public function signupBlogger(){

        $json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),User::$rules);
            if($validator->passes()):
                if(User::where('email',Input::get('email'))->exists() == FALSE):
                    if($account = self::getRegisterBloggerAccount(Input::all())):
                        Mail::send('emails.auth.signup',array('account'=>$account),function($message){
                            $message->from(Config::get('mail.from.address'),Config::get('mail.from.name'));
                            $message->to(Input::get('email'))->subject('LookBook - регистрация');
                        });
                        $json_request['responseText'] = Lang::get('interface.SIGNUP.success');
                        $json_request['status'] = TRUE;
                    endif;
                else:
                    $json_request['responseText'] = Lang::get('interface.SIGNUP.email_exist');
                endif;
            else:
                $json_request['responseText'] = Lang::get('interface.SIGNUP.fail');
            endif;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    public function activation($temporary_key = ''){

        if ($account = User::whereIn('active',array(1,2))->where('temporary_code',$temporary_key)->where('code_life','>=',time())->first()):
            $account->code_life = 0;
            $account->temporary_code = '';
            $account->active = 1;
            $account->save();
            $account->touch();
            Auth::login($account,TRUE);
            return Redirect::to(AuthAccount::getGroupStartUrl());
        else:
            return Redirect::to('/')->with('message.status','error')->with('message.text','Код активации не действителен.');
        endif;
    }

    /**************************************************************************/

    private function getRegisterBloggerAccount($post = NULL){

        $user = new User;
        if(!is_null($post)):
            $user->group_id = Group::where('name','blogger')->pluck('id');
            $user->name = $post['name'];
            $user->surname = '';
            $user->email = $post['email'];
            $user->active = 2;
            $user->password = Hash::make($post['password']);
            $user->photo = '';
            $user->thumbnail = '';
            $user->temporary_code = Str::random(24);
            $user->code_life = myDateTime::getFutureDays(5);
            $user->save();
            $user->touch();
            return $user;
        endif;
        return FALSE;
    }

}