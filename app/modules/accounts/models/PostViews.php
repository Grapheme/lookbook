<?php

class PostViews extends \BaseModel {

    protected $table = 'posts_views';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('post_id','user_id');
    public static $rules = array('post_id'=>'required','user_id'=>'required');

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function post() {
        return $this->belongsTo('Post', 'post_id');
    }
}