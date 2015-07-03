<?php

class BannersModeratorController extends BaseController {

    public static $name = 'promo';
    public static $group = 'moderator';
    public static $entity = 'moderator.promo';
    public static $entity_name = 'Кабинет модератор. Промо посты';

    /****************************************************************************/
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        if (Auth::check() && Auth::user()->group_id == 3):
            Route::group(array('before' => 'auth.status.moderator', 'prefix' => self::$group), function() use ($class) {
                Route::resource($class::$name, $class,
                    array(
                        'except' => array('show'),
                        'names' => array(
                            'index'  => self::$entity.'.index',
                            'create'  => self::$entity.'.create',
                            'stores'  => self::$entity.'.stores',
                            'edit'    => self::$entity.'.edit',
                            'update'  => self::$entity.'.update',
                            'destroy' => self::$entity.'.destroy',
                        )
                    )
                );
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
    public function index(){

        $posts = PostPromo::orderBy('order')->orderBy('id')->with('photo')->get();
        return View::make(Helper::acclayout('promo.index'),compact('posts'));
    }

    public function create(){

        return View::make(Helper::acclayout('promo.create'));
    }

    public function edit($post_id){

        if ($post = PostPromo::where('id',$post_id)->with('photo')->first()):
            return View::make(Helper::acclayout('promo.edit'),compact('post'));
        else:
            App::abort(404);
        endif;
    }

    public function store(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),PostPromo::$rules);
            if($validator->passes()):
                $post = new PostPromo();
                $post->start_date = (new myDateTime())->setDateString(Input::get('start_date'))->format('Y-m-d 00:00:00');
                $post->stop_date = (new myDateTime())->setDateString(Input::get('stop_date'))->format('Y-m-d 23:59:59');
                $post->position = Input::get('position');
                $post->order = Input::get('order');
                $post->link = Input::get('link');
                $post->photo_id = Input::get('photo_id');
                $post->video = Input::get('video');
                $post->save();
                $post->touch();
                $json_request['redirect'] = URL::route('moderator.promo.index');
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function update($post_id){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),PostPromo::$rules);
            if($validator->passes()):
                if($post = PostPromo::where('id',$post_id)->first()):
                    $post->start_date = (new myDateTime())->setDateString(Input::get('start_date'))->format('Y-m-d 00:00:00');
                    $post->stop_date = (new myDateTime())->setDateString(Input::get('stop_date'))->format('Y-m-d 23:59:59');
                    $post->position = Input::get('position');
                    $post->order = Input::get('order');
                    $post->link = Input::get('link');
                    $post->photo_id = Input::get('photo_id');
                    $post->video = Input::get('video');
                    $post->save();
                    $post->touch();
                    $json_request['redirect'] = URL::route('moderator.promo.index');
                    $json_request['status'] = TRUE;
                endif;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function destroy($post_id){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            if($post = PostPromo::where('id',$post_id)->first()):
                if($photo = Photo::where('id', $post->photo_id)->first()):
                    if (!empty($photo->name) && File::exists(Config::get('site.galleries_photo_dir').'/'.$photo->name)):
                        File::delete(Config::get('site.galleries_photo_dir').'/'.$photo->name);
                    endif;
                    if (!empty($photo->name) && File::exists(Config::get('site.galleries_thumb_dir').'/'.$photo->name)):
                        File::delete(Config::get('site.galleries_thumb_dir').'/'.$photo->name);
                    endif;
                    $photo->delete();
                endif;
                $post->delete();
                $json_request['redirect'] = URL::route('moderator.promo.index');
                $json_request['status'] = TRUE;
            endif;
        endif;
        return Response::json($json_request,200);
    }
    /****************************************************************************/
}