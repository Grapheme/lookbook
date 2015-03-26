<?php

class PostBloggerController extends BaseController {

    public static $name = 'blogger';
    public static $group = 'posts';
    public static $entity = 'posts';
    public static $entity_name = 'Пост блогера';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        if (Auth::check() && Auth::user()->group_id == 4):
            Route::group(array('before'=>'auth.status.blogger','prefix' => self::$name), function() use ($class) {
                Route::resource($class::$group, $class,
                    array(
                        'except' => array('index'),
                        'names' => array(
                            'show'    => self::$entity.'.show',
                            'create'  => self::$entity.'.create',
                            'store'   => self::$entity.'.store',
                            'edit'    => self::$entity.'.edit',
                            'update'  => self::$entity.'.update',
                            'destroy' => self::$entity.'.destroy',
                        )
                    )
                );
                Route::post('posts/preview',array('as'=>'post.preview','uses'=>$class.'@preview'));
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

    public function preview(){

        $json_request = array('status'=>FALSE,'html'=>'','redirect'=>FALSE);
        $validator = Validator::make(Input::all(),[]);
        if($validator->passes()):
            $post = array(
                'user_id' => Auth::user()->id,
                'publish_at' => (new myDateTime())->setDateString(Input::get('publish_at'))->format('Y-m-d'),
                'category_id' => Input::get('category_id'),
                'subcategory_id' => Input::get('subcategory_id'),
                'publication_type' => Input::get('publication_type'),
                'title' => Input::get('title'),
                'content' => Input::get('content'),
                'publication' => 0,
                'photo' => FALSE,
                'gallery' => FALSE
            );
            if (Input::has('photo_id') && Input::get('photo_id') > 0):
                $post['photo'] = Photo::where('id',Input::get('photo_id'))->pluck('name');
            endif;
            if (Input::has('gallery') && Input::has('gallery.uploaded_images') > 0):
                $post['gallery'] = Photo::whereIn('id',Input::get('gallery.uploaded_images'))->lists('name','id');
            endif;
            $json_request['html'] = View::make(Helper::acclayout('posts.show'),compact('post'))->render();
            $json_request['status'] = TRUE;
        else:
            return Redirect::back()->withErrors($validator->messages()->all());
        endif;
        return Response::json($json_request,200);
    }

    public function show($post_id){
        if ($post = Post::where('user_id',Auth::user()->id)->with('publication_type','category','subcategory','comments','photo','gallery')->first()):
            return View::make(Helper::acclayout('posts.show'),compact('post'));
        else:
            App::abort(404);
        endif;

    }

    public function create(){

        return View::make(Helper::acclayout(self::$entity.'.create'));
    }

    public function store(){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),Post::$rules);
            if($validator->passes()):
                $galleryID = ExtForm::process('gallery',array('module'=>'my','unit_id'=>0,'gallery'=>Input::get('gallery'),'single'=>TRUE));
                $newPost = Post::create(array(
                    'user_id' => Auth::user()->id,
                    'publish_at' => (new myDateTime())->setDateString(Input::get('publish_at'))->format('Y-m-d'),
                    'category_id' => Input::get('category_id'),
                    'subcategory_id' => Input::get('subcategory_id'),
                    'publication_type' => Input::get('publication_type'),
                    'title' => Input::get('title'),
                    'content' => Input::get('content'),
                    'photo_id' => Input::get('photo_id'),
                    'gallery_id' => $galleryID,
                    'publication' => 0
                ));
                $json_request['responseText'] = Lang::get('interface.DEFAULT.success_insert');
                $json_request['redirect'] = URL::route('posts.show',$newPost->id.'-'.BaseController::stringTranslite($newPost->title));
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = $validator->messages()->all();
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function edit(){


    }

    public function update(){

    }

    public function destroy(){


    }
    /****************************************************************************/
    /**************************************************************************/
    /****************************************************************************/
}