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
                Route::get('profile', array('as' => 'blogger-profile', 'uses' => $class . '@profile'));
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
    public function profile(){

        $page_data = array(
            'page_title'=> Lang::get('seo.COMPANY_LISTENER_PROFILE.title'),
            'page_description'=> Lang::get('seo.COMPANY_LISTENER_PROFILE.description'),
            'page_keywords'=> Lang::get('seo.COMPANY_LISTENER_PROFILE.keywords'),
            'profile' => User_listener::where('id',Auth::user()->id)->first()
        );
        return View::make(Helper::acclayout('profile'),$page_data);
    }

    public function profileEdit(){

        $page_data = array(
            'page_title'=> Lang::get('seo.COMPANY_LISTENER_PROFILE.title'),
            'page_description'=> Lang::get('seo.COMPANY_LISTENER_PROFILE.description'),
            'page_keywords'=> Lang::get('seo.COMPANY_LISTENER_PROFILE.keywords'),
            'profile' => User_listener::where('id',Auth::user()->id)->first()
        );
        return View::make(Helper::acclayout('profile-edit'),$page_data);
    }

    public function profileUpdate(){

        $json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
        if(self::activism()):
            return App::abort(404);
        endif;
        if(Request::ajax() && isCompanyListener()):
            $validator = Validator::make(Input::all(),Listener::$update_rules);
            if($validator->passes()):
                if (self::ListenerAccountUpdate(Input::all())):
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.success_save');
                    $json_request['redirect'] = URL::route('listener-profile');
                    $json_request['status'] = TRUE;
                else:
                    $json_request['responseText'] = Lang::get('interface.DEFAULT.fail');
                endif;
            else:
                $json_request['responseText'] = Lang::get('interface.DEFAULT.fail');
                $json_request['responseErrorText'] = $validator->messages()->all();
            endif;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    private function accountUpdate($post){

        $user = Auth::user();
        if($listener = Listener::where('user_id',$user->id)->first()):
            $fio = explode(' ',$post['fio']);
            $user->name = (isset($fio[1]))?$fio[1]:'';
            $user->surname = (isset($fio[0]))?$fio[0]:'';
            $user->save();
            $user->touch();

            $listener->approved = $post['approved'];
            $listener->fio = $post['fio'];
            $listener->fio_dat = $post['fio_dat'];
            $listener->position = $post['position'];
            $listener->postaddress = $post['postaddress'];
            $listener->phone = $post['phone'];
            $listener->education = $post['education'];
            $listener->education_document_data = $post['education_document_data'];
            $listener->educational_institution = $post['educational_institution'];
            $listener->specialty = $post['specialty'];
            $listener->save();
            $listener->touch();

            return TRUE;
        else:
            return FALSE;
        endif;
    }
    /**************************************************************************/
}