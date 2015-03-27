<?php

class Post extends BaseModel{

    protected $table = 'posts';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('user_id','publication_type','category_id','subcategory_id','publish_at','title','content','photo_id','gallery_id');
    public static $rules = array('publish_at'=>'required','title'=>'required','content'=>'required');

    public function user() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function publication_type() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function category() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function subcategory() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function photo() {
        return $this->hasOne('Photo', 'id', 'photo_id');
    }

    public function gallery() {
        return $this->hasOne('Gallery', 'id', 'gallery_id');
    }

    public function views(){

        return $this->hasMany('PostViews','id','post_id');
    }

    public function likes(){

        return $this->hasMany('PostLikes','id','post_id');
    }

    public function comments(){

        return $this->hasMany('PostComments','id','post_id');
    }
}