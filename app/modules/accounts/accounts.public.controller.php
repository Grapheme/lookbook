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
    public function __construct() {}
    /****************************************************************************/
    public static function getTopBloggers(){

        $users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
            ->join('posts', 'posts_views.post_id', '=', 'posts.id')
            ->groupBy('posts.user_id')->orderBy('users_views', 'DESC')
            ->lists('users_views', 'post_user_id');
        $top_bloggers = array();
        if ($users_top_posts):
            $top_bloggers_ids = array();
            foreach (Accounts::whereIn('id', array_keys($users_top_posts))->where('active', 1)->where('brand', 0)->take(Config::get('lookbook.count_top_bloggers'))->with('me_signed')->get() as $blogger):
                $top_bloggers[$blogger->id] = $blogger;
                $top_bloggers_ids[] = $blogger->id;
            endforeach;
            $users_top_posts_temp = $users_top_posts;
            $users_top_posts = array();
            foreach ($users_top_posts_temp as $user_id => $users_views):
                if (in_array($user_id, $top_bloggers_ids)):
                    $users_top_posts[$user_id] = $users_views;
                endif;
            endforeach;
            array_multisort($top_bloggers, SORT_DESC, array_keys($users_top_posts));
        endif;
        return array('top_bloggers' => $top_bloggers, 'users_top_posts' => $users_top_posts);
    }

    public static function getTopBrands(){

        $users_top_posts = PostViews::select(DB::raw('posts.user_id as post_user_id,COUNT(posts_views.post_id) as users_views'))
            ->join('posts', 'posts_views.post_id', '=', 'posts.id')
            ->groupBy('posts.user_id')->orderBy('users_views', 'DESC')
            ->lists('users_views', 'post_user_id');
        $top_bloggers = array();
        if ($users_top_posts):
            $top_bloggers_ids = array();
            foreach (Accounts::whereIn('id', array_keys($users_top_posts))->where('active', 1)->where('brand', 1)->take(Config::get('lookbook.count_top_bloggers'))->with('me_signed')->get() as $blogger):
                $top_bloggers[$blogger->id] = $blogger;
                $top_bloggers_ids[] = $blogger->id;
            endforeach;
            $users_top_posts_temp = $users_top_posts;
            $users_top_posts = array();
            foreach ($users_top_posts_temp as $user_id => $users_views):
                if (in_array($user_id, $top_bloggers_ids)):
                    $users_top_posts[$user_id] = $users_views;
                endif;
            endforeach;
            array_multisort($top_bloggers, SORT_DESC, array_keys($users_top_posts));
        endif;
        return array('top_bloggers' => $top_bloggers, 'users_top_posts' => $users_top_posts);
    }
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