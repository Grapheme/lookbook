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
                Route::post('posts/preview',array('as'=>'post.preview','uses'=>$class.'@preview'));
                Route::put('posts/preview',array('as'=>'post.preview','uses'=>$class.'@preview'));
                Route::post('posts/{post_id}/auto-save',array('as'=>'post.auto.save','uses'=>$class.'@autoSave'));
                Route::put('posts/{post_id}/auto-save',array('as'=>'post.auto.save','uses'=>$class.'@autoSave'));
                Route::resource($class::$group, $class,
                    array(
                        'except' => array('index','show','stores'),
                        'names' => array(
                            'create'  => self::$entity.'.create',
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
    /****************************************************************************/

    public function preview(){

        $json_request = array('status'=>FALSE,'html'=>'','redirect'=>FALSE);
        $validator = Validator::make(Input::all(),[]);
        if($validator->passes()):
            list($categories,$tags) = self::getCategoriesAndTags();
            $post = array(
                'user_id' => Auth::user()->id,
                'publish_at' => (new myDateTime())->setDateString(Input::get('publish_at'))->format('Y-m-d'),
                'category_id' => isset($categories[Input::get('category_id')]) ? $categories[Input::get('category_id')] : '',
                'subcategory_id' => isset($subcategories[Input::get('subcategory_id')]) ? $subcategories[Input::get('subcategory_id')]['name'] : '',
                'title' => Input::get('title'),
                'content' => Input::get('content'),
                'publication' => 0,
                'photo' => FALSE,
                'photo_title' => Input::get('photo_title'),
                'gallery' => FALSE,
                'tags' => array()
            );
            if (Input::has('photo_id') && Input::get('photo_id') > 0):
                $post['photo'] = Photo::where('id',Input::get('photo_id'))->pluck('name');
            endif;
            if (Input::has('gallery') && Input::has('gallery.uploaded_images') > 0):
                $post['gallery'] = Photo::whereIn('id',Input::get('gallery.uploaded_images'))->lists('name','id');
            elseif(Input::has('gallery.gallery_id') && Input::get('gallery.gallery_id') > 0):
                $post['gallery'] = Gallery::where('id',Input::get('gallery.gallery_id'))->first()->photos()->lists('name');
            endif;
            if (Input::has('tags')):
                $post['tags'] = self::getTags(array(),Input::get('tags'),$tags,Input::get('category_id'));
            endif;
            Config::set('noscripts',TRUE);
            $json_request['html'] = View::make(Helper::acclayout('posts.preview'),compact('post','categories','tags'))->render();
            $json_request['status'] = TRUE;
        else:
            return Redirect::back()->withErrors($validator->messages()->all());
        endif;
        return Response::json($json_request,200);
    }

    public function create(){

        #Helper::tad(Dic::all());
        $catID = Dictionary::valuesBySlug('categories')->first()->id;
        $post = Post::create(array('user_id'=>Auth::user()->id,'publish_at'=>(new myDateTime())->format('Y-m-d'),'category_id'=>$catID,'title'=>'Новый пост','content'=>'','photo_id'=>0,'photo_title'=>'','gallery_id'=>0,'publication'=>0));
        $gallery = Gallery::create(array('name'=>'Пост - '.$post->id));
        $post->gallery_id = $gallery->id;
        $post->save();
        return Redirect::route('posts.edit',$post->id);
    }

    public function edit($post_id){

        if ($post = Post::where('id',$post_id)->where('user_id',Auth::user()->id)->with('tags_ids','photo','gallery')->first()):
            list($categories,$tags) = self::getCategoriesAndTags();
            if (isset($categories[$post->category_id])):
                $post->category_title = $categories[$post->category_id];
            endif;
            if ($post->tags_ids->count()):
                $tagsIDs = array();
                foreach($post->tags_ids as $tag):
                    $tagsIDs[] = $tag->tag_id;
                endforeach;
                if (count($tagsIDs)):
                    $post->tags = self::getTags(array(),$tagsIDs,$tags,$post->category_id);
                endif;
            endif;
            return View::make(Helper::acclayout('posts.edit'),compact('post','categories','tags'));
        else:
            App::abort(404);
        endif;
    }

    public function autoSave($post_id){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),Post::$rules);
            if($validator->passes()):
                Post::where('id',$post_id)->where('user_id',Auth::user()->id)->update(array(
                    'publish_at' => (new myDateTime())->setDateString(Input::get('publish_at'))->format('Y-m-d'),
                    'category_id' => Input::get('category_id'),
                    'title' => Input::get('title'),
                    'content' => Input::get('content'),
                    'photo_id' => Input::get('photo_id'),
                    'photo_title' => Input::get('photo_title')
                ));
                $gallery_id = ExtForm::process('gallery',array('module'=>'Пост','unit_id'=>$post_id,'gallery'=>Input::get('gallery'),'single'=>TRUE));
                Post::where('id',$post_id)->where('user_id',Auth::user()->id)->update(array('gallery_id'=>$gallery_id));
                if (Input::has('tags')):
                    Post::where('id',$post_id)->first()->tags()->sync(Input::get('tags'));
                endif;
                $json_request['status'] = TRUE;
                $json_request['responseText'] = Lang::get('interface.DEFAULT.success_save_auto');
            endif;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }

    public function update($post_id){

        $json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(),Post::$rules);
            if($validator->passes()):
                Post::where('id',$post_id)->where('user_id',Auth::user()->id)->update(array(
                    'publish_at' => (new myDateTime())->setDateString(Input::get('publish_at'))->format('Y-m-d'),
                    'category_id' => Input::get('category_id'),
                    'title' => Input::get('title'),
                    'content' => Input::get('content'),
                    'photo_id' => Input::get('photo_id'),
                    'photo_title' => Input::get('photo_title'),
                    'publication' => 1
                ));
                $gallery_id = ExtForm::process('gallery',array('module'=>'Пост','unit_id'=>$post_id,'gallery'=>Input::get('gallery'),'single'=>TRUE));
                Post::where('id',$post_id)->where('user_id',Auth::user()->id)->update(array('gallery_id'=>$gallery_id));
                if (Input::has('tags')):
                    Post::where('id',$post_id)->first()->tags()->sync(Input::get('tags'));
                endif;
                $json_request['responseText'] = Lang::get('interface.DEFAULT.success_save');
                #$json_request['redirect'] = URL::route('posts.show',$post_id.'-'.BaseController::stringTranslite(Input::get('title')));
                $json_request['redirect'] = URL::route('dashboard');
                $json_request['status'] = TRUE;
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
            if($gallery = Post::where('id',$post_id)->where('user_id',Auth::user()->id)->first()->gallery):
                $photos =  $gallery->photos;
                foreach($gallery->photos as $photo):
                    if (!empty($photo->name) && File::exists(Config::get('site.galleries_photo_dir').'/'.$photo->name)):
                        File::delete(Config::get('site.galleries_photo_dir').'/'.$photo->name);
                    endif;
                    if (!empty($photo->name) && File::exists(Config::get('site.galleries_thumb_dir').'/'.$photo->name)):
                        File::delete(Config::get('site.galleries_thumb_dir').'/'.$photo->name);
                    endif;
                    $photo->delete();
                endforeach;
                $gallery->delete();
            endif;
            if($photo = Post::where('id',$post_id)->where('user_id',Auth::user()->id)->first()->photo):
                if (!empty($photo->name) && File::exists(Config::get('site.galleries_photo_dir').'/'.$photo->name)):
                    File::delete(Config::get('site.galleries_photo_dir').'/'.$photo->name);
                endif;
                if (!empty($photo->name) && File::exists(Config::get('site.galleries_thumb_dir').'/'.$photo->name)):
                    File::delete(Config::get('site.galleries_thumb_dir').'/'.$photo->name);
                endif;
                $photo->delete();
            endif;
            Post::where('id',$post_id)->where('user_id',Auth::user()->id)->first()->views()->delete();
            Post::where('id',$post_id)->where('user_id',Auth::user()->id)->first()->likes()->delete();
            Post::where('id',$post_id)->where('user_id',Auth::user()->id)->first()->comments()->delete();
            Post::where('id',$post_id)->where('user_id',Auth::user()->id)->first()->tags_ids()->delete();
            Post::where('id',$post_id)->where('user_id',Auth::user()->id)->delete();

            $json_request['responseText'] = Lang::get('interface.DEFAULT.success_remove');
            $json_request['status'] = TRUE;
        else:
            return Redirect::back();
        endif;
        return Response::json($json_request,200);
    }
    /****************************************************************************/
    /**************************************************************************/
    public static function getCategoriesAndTags(){

        $categories = array();
        $tags = array();

        if($cats = Dictionary::valuesBySlug('categories')):
            $cats = DicLib::extracts($cats,NULL,TRUE,TRUE);
            foreach($cats as $cat_id => $cat):
                $categories[$cat_id] = $cat['name'];
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
        endif;
        return array($categories,$tags);
    }

    public static function getTags($array,$tags_post,$tags,$category_id = NULL){

        foreach($tags_post as $tag_id):
            if (isset($tags[$category_id]['category_tags'][$tag_id])):
                $array[$tag_id] = $tags[$category_id]['category_tags'][$tag_id];
            endif;
        endforeach;
        return $array;
    }
    /****************************************************************************/
}