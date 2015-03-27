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
            list($categories,$subcategories,$tags) = self::getCategoriesAndTags();
            $post = array(
                'user_id' => Auth::user()->id,
                'publish_at' => (new myDateTime())->setDateString(Input::get('publish_at'))->format('Y-m-d'),
                'category_id' => isset($categories[Input::get('category_id')]) ? $categories[Input::get('category_id')] : '',
                'subcategory_id' => isset($subcategories[Input::get('subcategory_id')]) ? $subcategories[Input::get('subcategory_id')]['name'] : '',
                'title' => Input::get('title'),
                'content' => Input::get('content'),
                'publication' => 0,
                'photo' => FALSE,
                'gallery' => FALSE,
                'tags' => array()
            );
            if (Input::has('photo_id') && Input::get('photo_id') > 0):
                $post['photo'] = Photo::where('id',Input::get('photo_id'))->pluck('name');
            endif;
            if (Input::has('gallery') && Input::has('gallery.uploaded_images') > 0):
                $post['gallery'] = Photo::whereIn('id',Input::get('gallery.uploaded_images'))->lists('name','id');
            endif;
            if (Input::has('tags')):
                $post['tags'] = self::getTags($post,Input::get('tags'),$tags,Input::get('category_id'),Input::get('subcategory_id'));
            endif;
            $json_request['html'] = View::make(Helper::acclayout('posts.show'),compact('post'))->render();
            $json_request['status'] = TRUE;
        else:
            return Redirect::back()->withErrors($validator->messages()->all());
        endif;
        return Response::json($json_request,200);
    }

    public function show($post_id){

        if ($post = Post::where('id',(int)$post_id)->where('user_id',Auth::user()->id)->with('tags_ids','comments','photo','gallery')->first()):
            list($categories,$subcategories,$tags) = self::getCategoriesAndTags();
            if (isset($categories[$post->category_id])):
                $post->category_title = $categories[$post->category_id];
            endif;
            if (isset($subcategories[$post->subcategory_id])):
                $post->subcategory_title = $subcategories[$post->subcategory_id]['name'];
            endif;
            if ($post->tags_ids->count()):
                $tagsIDs = array();
                foreach($post->tags_ids as $tag):
                    $tagsIDs[] = $tag->tag_id;
                endforeach;
                if (count($tagsIDs)):
                    $post->tags = self::getTags(array(),$tagsIDs,$tags,$post->category_id,$post->subcategory_id);
                endif;
            endif;
            return View::make(Helper::acclayout('posts.show'),compact('post'));
        else:
            App::abort(404);
        endif;

    }

    public function create(){

        list($categories,$subcategories,$tags) = self::getCategoriesAndTags();
        return View::make(Helper::acclayout(self::$entity.'.create'),compact('categories','subcategories','tags'));
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
                    'title' => Input::get('title'),
                    'content' => Input::get('content'),
                    'photo_id' => Input::get('photo_id'),
                    'gallery_id' => $galleryID,
                    'publication' => 0
                ));
                if (Input::has('tags')):
                    Post::where('id',$newPost->id)->first()->tags()->sync(Input::get('tags'));
                endif;
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
    public static function getCategoriesAndTags(){

        $categories = array();
        $subcategories = array();
        $tags = array();

        if($cats = Dictionary::valuesBySlug('categories')):
            $cats = DicLib::extracts($cats,NULL,TRUE,TRUE);
            foreach($cats as $cat_id => $cat):
                $categories[$cat_id] = $cat['name'];
            endforeach;
        endif;
        if($subcats = Dictionary::valuesBySlug('subcategories')):
            $subcats = DicLib::extracts($subcats,NULL,TRUE,TRUE);
            foreach($subcats as $cat_id => $cat):
                $subcategories[$cat_id] = array('id'=>$cat_id,'name'=>$cat['name'],'category_id'=>$cat['category_id']);
            endforeach;
        endif;
        if (!empty($categories)):
            foreach ($categories as $cat_id => $cat_title):
                if (isset($cats[$cat_id]['tags_id']) && !empty($cats[$cat_id]['tags_id'])):
                    foreach($cats[$cat_id]['tags_id'] as $tag_id => $tag):
                        $tags[$cat_id]['category_tags'][$tag_id] = $tag['name'];
                    endforeach;
                endif;
            endforeach;
            if (!empty($subcategories)):
                foreach ($subcategories as $subcat_id => $subcat):
                    $tmpsubcategories[$subcat['category_id']][] = $subcat_id;
                endforeach;
                foreach ($tmpsubcategories as $tmpsubcat_cat_id => $tmpsubcat):
                    foreach($tmpsubcat as $tmpsubcat_id):
                        if (isset($subcats[$tmpsubcat_id]['tags_id']) && !empty($subcats[$tmpsubcat_id]['tags_id'])):
                            foreach($subcats[$tmpsubcat_id]['tags_id'] as $tag_id => $tag):
                                $tags[$tmpsubcat_cat_id]['subcategory_tags'][$tmpsubcat_id][$tag_id] = $tag['name'];
                            endforeach;
                        endif;
                    endforeach;
                endforeach;
            endif;
        endif;
        return array($categories,$subcategories,$tags);
    }

    public static function getTags($array,$tags_post,$tags,$category_id = NULL,$subcategory_id = NULL){

        foreach($tags_post as $tag_id):
            if (!is_null($subcategory_id) && $subcategory_id > 0 && $category_id):
                if (isset($tags[$category_id]['subcategory_tags'][$subcategory_id][$tag_id])):
                    $array[$tag_id] = $tags[$category_id]['subcategory_tags'][$subcategory_id][$tag_id];
                endif;
            else:
                if (isset($tags[$category_id]['category_tags'][$tag_id])):
                    $array[$tag_id] = $tags[$category_id]['category_tags'][$tag_id];
                endif;
            endif;
        endforeach;
        return $array;
    }
    /****************************************************************************/
}