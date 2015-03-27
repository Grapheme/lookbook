<?php

class Post extends BaseModel{

    protected $table = 'posts';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('user_id','category_id','subcategory_id','publish_at','title','content','photo_id','gallery_id');
    public static $rules = array('publish_at'=>'required','title'=>'required','content'=>'required');

    public function user() {
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

    public function tags() {
        return $this->belongsToMany('PostTags','posts_tags', 'post_id', 'tag_id');
    }

    public function tags_ids() {
        return $this->hasMany('PostTags','post_id','id');
    }

    public function views(){

        return $this->hasMany('PostViews','post_id','id');
    }

    public function likes(){

        return $this->hasMany('PostLikes','post_id','id');
    }

    public function comments(){

        return $this->hasMany('PostComments','post_id','id');
    }
}