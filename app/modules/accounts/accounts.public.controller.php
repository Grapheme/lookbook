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
    public static function getTopBloggers() {

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

    public static function getTopBrands() {

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

    public static function getPlaceRating($user_id) {

        $rating_place = 0;
        $rating_list = BloggerSubscribe::select(DB::raw('blogger_id as subscribe_user_id, COUNT(blogger_id) as subscribes'))->groupBy('blogger_id')->orderBy('subscribes', 'DESC')->get();
        if ($rating = self::calculateRating($rating_list)):
            foreach ($rating as $place => $user_rating):
                if ($user_rating['user_id'] == $user_id):
                    $rating_place = $place;
                    break;
                endif;
            endforeach;
        endif;
        return $rating_place;
    }

    /****************************************************************************/
    private static function calculateRating($rating_list) {

        if (count($rating_list)):
            foreach ($rating_list as $index => $user_rating):
                $rating[$index + 1]['user_id'] = $user_rating->subscribe_user_id;
                $rating[$index + 1]['subscribes'] = $user_rating->subscribes;
                $rating[$index + 1]['you'] = FALSE;
            endforeach;
            return $rating;
        else:
            return array();
        endif;
    }

    /****************************************************************************/
    public function contactsSendQuestion() {

        $json_request = array('status' => FALSE, 'responseText' => '', 'redirect' => FALSE);
        if (Request::ajax()):
            $validator = Validator::make(Input::all(), array('name' => 'required', 'email' => 'required|email',
                'message' => 'required'));
            if ($validator->passes()):
                $address = array(
                    'e8bf00b49e1915193b17b05a3618e142' => array('support@look-book.ru', 'andreevaelena@look-book.ru'),
                    '2ccd5aba1d18ed8bee786d07932f1654' => array('advertisement@look-book.ru', 'andreevaelena@look-book.ru'),
                    'ff85aee93c947bdd5bd6258927d940d4' => array('info@look-book.ru', 'andreevaelena@look-book.ru'),
                    '582c0147cd6c7f01b1fb65eff50dcb94' => array('ipatovavera@look-book.ru', 'andreevaelena@look-book.ru')
                );
                $theme = md5(Input::get('theme'));
                $sending = array(Config::get('mail.feedback.address'));
                if (isset($address[$theme])):
                    $sending = $address[$theme];
                endif;
                foreach ($sending as $to_email):
                    Mail::send('emails.feedback', array('post' => Input::all()), function ($message) use ($to_email) {
                        $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                        $message->to($to_email)->subject(Input::get('theme'));
                    });
                endforeach;
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