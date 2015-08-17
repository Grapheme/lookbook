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
    public static function getTopPosts($category_id = NULL){

        $top_posts_raw = DB::table('posts')
            ->select(DB::raw('posts.id, posts.user_id, (posts.guest_views+count(posts_views.id)) as total_summ'))
            ->join('posts_views', 'posts.id', '=', 'posts_views.post_id')
            ->groupBy('posts.id')
            ->where('posts.publication', 1)
            ->orderBy('total_summ', 'DESC')
            ->take(Config::get('lookbook.count_top_posts'));
        if(!is_null($category_id)):
            $top_posts_raw = $top_posts_raw->where('posts.category_id', $category_id);
        endif;
        $top_posts_raw = $top_posts_raw->get();
        $top_posts = array();
        if($top_posts_raw):
            $views = array();
            foreach($top_posts_raw as $top_post):
                $posts_ids[] = $top_post->id;
                $views[$top_post->id] = $top_post->total_summ;
            endforeach;
            foreach(Post::whereIn('id', $posts_ids)->with('user','photo')->get() as $post):
                $post->content = '';
                $post->user->about = '';
                $top_posts[$post->id] = $post->toArray();
            endforeach;
            $tmp = $top_posts;
            $top_posts = array();
            foreach($posts_ids as $post_id):
                foreach($tmp as $top_post_id => $post):
                    if($top_post_id == $post_id):
                        $top_posts[$post_id] = $post;
                        $top_posts[$post_id]['views'] = $views[$post_id];
                    endif;
                endforeach;
            endforeach;
        endif;
        return $top_posts;
    }

    public static function getTopBloggers($brand = 0, $category_id = NULL) {

        $top_posts_raw = DB::table('posts')
            ->select(DB::raw('posts.user_id as user_id, (posts.guest_views+count(posts_views.id)) as users_views'))
            ->join('posts_views', 'posts.id', '=', 'posts_views.post_id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->groupBy('posts.user_id')
            ->where('posts.publication', 1)
            ->where('users.brand', $brand)
            ->where('users.active', 1)
            ->orderBy('users_views', 'DESC')
            ->take(Config::get('lookbook.count_top_bloggers'));
        if(!is_null($category_id)):
            $top_posts_raw = $top_posts_raw->where('posts.category_id', $category_id);
        endif;
            $top_posts_raw = $top_posts_raw->get();
        $users_top_posts = array();
        foreach($top_posts_raw as $top_post):
            $users_top_posts[$top_post->user_id] = $top_post->users_views;
        endforeach;
        $top_bloggers = array();
        if ($users_top_posts):
            $users = Accounts::whereIn('id', array_keys($users_top_posts))->with('me_signed')->get();
            foreach($users_top_posts as $user_id => $post_views):
                foreach($users as $user):
                    if($user->id == $user_id):
                        $users_top_posts[$user_id] = $user->toArray();
                        $users_top_posts[$user_id]['views'] = $post_views;
                    endif;
                endforeach;
            endforeach;
        endif;
        return $users_top_posts;
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