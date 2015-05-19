<?php

class Accounts extends BaseModel {

	protected $table = 'users';

	protected $guarded = array();

	protected $hidden = array('password');

    public function posts(){

        return $this->hasMany('Post','user_id','id');
    }

    public function blogger_subscribes(){

        return $this->belongsToMany('BloggerSubscribe','users_blogger_subscribes', 'user_id', 'blogger_id');
    }
}