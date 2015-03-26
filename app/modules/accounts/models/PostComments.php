<?php

class PostComments extends \BaseModel {

    protected $table = 'posts_comments';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('post_id','user_id','content','rating');
    public static $rules = array('post_id'=>'required','user_id'=>'required','content'=>'required','rating'=>'required');

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function post() {
        return $this->belongsTo('Post', 'post_id');
    }
}