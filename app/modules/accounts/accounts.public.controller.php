<?php

class AccountsPublicController extends BaseController {

    public static $name = 'public';
    public static $group = 'accounts';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::post('contacts/send-question', array('before' => 'csrf', 'as' => 'contacts-send-question',
            'uses' => $class . '@contactsSendQuestion'));
    }

    public static function returnShortCodes() {
    }

    public static function returnActions() {
    }

    public static function returnInfo() {
    }

    public static function returnMenu() {
    }

    /****************************************************************************/
    public function __construct() {
    }
    /****************************************************************************/
    /****************************************************************************/
    public function contactsSendQuestion() {

        $json_request = array('status' => FALSE, 'responseText' => '', 'redirect' => FALSE);
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), array('name' => 'required', 'email' => 'required|email',
                'message' => 'required'));
            if ($validator->passes()):
                Mail::send('emails.feedback', array('post' => Input::all()), function ($message) {
                    $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                    $message->to(Config::get('mail.feedback.address'))->subject('LookBook - Обратная связь');
                });
                $json_request['responseText'] = Lang::get('interface.MAIL.success_send');
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request, 200);
    }

}