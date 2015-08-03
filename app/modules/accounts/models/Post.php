<?php

class Post extends BaseModel{

    protected $table = 'posts';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('user_id','category_id','publish_at','title','content','photo_id','photo_title','gallery_id');
    public static $rules = array('category_id'=>'required','publish_at'=>'required','title'=>'','content'=>'');

    public function user() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function photo() {
        return $this->hasOne('Photo', 'id', 'photo_id');
    }

    public function promoted_photo() {
        return $this->hasOne('Photo', 'id', 'promoted_photo_id');
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

        return $this->hasMany('PostComments','post_id','id')->orderBy('created_at', 'DESC');
    }
}