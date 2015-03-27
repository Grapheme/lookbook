<?php

class PostTags extends \BaseModel {

    protected $table = 'posts_tags';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('post_id','tag_id');
    public static $rules = array('post_id'=>'required','tag_id'=>'required');

    public function post() {
        return $this->belongsTo('Post', 'post_id');
    }

    public function tag() {
        #
    }
}