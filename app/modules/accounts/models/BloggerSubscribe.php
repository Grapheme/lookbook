<?php

class BloggerSubscribe extends BaseModel {

	protected $table = 'users_blogger_subscribes';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('user_id','blogger_id');
    public static $rules = array('user_id'=>'required','blogger_id'=>'required');

    public function user() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function blogger() {
        return $this->hasOne('User', 'id', 'blogger_id');
    }
}